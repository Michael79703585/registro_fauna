<?php

namespace App\Http\Controllers;

use App\Models\Transferencia;
use App\Models\Fauna;
use App\Models\HistorialClinico;
use App\Models\HistorialTransferencia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Institucion;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransferenciasExport;
use Illuminate\Support\Facades\DB;

class TransferenciaController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $faunasRegistradas = Fauna::where('user_id', $user->id)->pluck('id');
        $faunasTransferidas = Transferencia::where('institucion_destino', $user->institucion_id)
            ->pluck('fauna_id');

        $faunaIds = $faunasRegistradas->merge($faunasTransferidas)->unique();

        $faunas = Fauna::whereIn('id', $faunaIds)->get();
        $instituciones = Institucion::all();

        return view('transferencias.create', compact('faunas', 'instituciones'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $faunasRegistradas = Fauna::where('user_id', $user->id)->pluck('id');
        $faunasTransferidas = Transferencia::where('institucion_destino', $user->institucion_id)
            ->pluck('fauna_id');

        $faunaIds = $faunasRegistradas->merge($faunasTransferidas)->unique();

        $query = Transferencia::whereIn('fauna_id', $faunaIds);

        if ($request->filled('codigo')) {
            $query->whereHas('fauna', function ($q) use ($request) {
                $q->where('codigo', 'like', '%' . $request->codigo . '%');
            });
        }

        if ($request->filled('fecha_transferencia')) {
            $query->whereDate('fecha_transferencia', $request->fecha_transferencia);
        }

        if ($request->filled('destino')) {
            $query->whereHas('institucionDestino', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->destino . '%');
            });
        }

        $transferencias = $query->with(['fauna', 'institucionDestino'])->latest()->paginate(10);

        return view('transferencias.index', compact('transferencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fauna_id' => 'required|exists:faunas,id',
            'institucion_destino' => 'required|exists:instituciones,id',
            'motivo' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        Transferencia::create([
            'fauna_id' => $request->fauna_id,
            'institucion_origen' => $user->institucion_id,
            'institucion_destino' => $request->institucion_destino,
            'fecha_transferencia' => now(),
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('transferencias.index')->with('success', 'Solicitud de transferencia enviada correctamente.');
    }

    public function edit($id)
    {
        $transferencia = Transferencia::findOrFail($id);
        $faunas = Fauna::all();
        $instituciones = Institucion::all();

        return view('transferencias.edit', compact('transferencia', 'faunas', 'instituciones'));
    }

    public function update(Request $request, $id)
    {
        $transferencia = Transferencia::findOrFail($id);

        if ($transferencia->estado !== 'pendiente') {
            return redirect()->route('transferencias.index')->with('error', 'Solo se pueden editar solicitudes pendientes.');
        }

        $request->validate([
            'fauna_id' => 'required|exists:faunas,id',
            'institucion_origen' => 'required|exists:instituciones,id',
            'institucion_destino' => 'required|exists:instituciones,id',
            'motivo' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'estado' => 'required|in:pendiente,aceptado,rechazado',
            'fecha_transferencia' => 'nullable|date',
        ]);

        $transferencia->update([
            'fauna_id' => $request->fauna_id,
            'institucion_origen' => $request->institucion_origen,
            'institucion_destino' => $request->institucion_destino,
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones,
            'estado' => $request->estado,
            'fecha_transferencia' => $request->estado === 'aceptado'
                ? ($request->fecha_transferencia ?? now()->toDateString())
                : null,
        ]);

        return redirect()->route('transferencias.index')->with('success', 'Solicitud actualizada correctamente.');
    }

    public function destroy($id)
    {
        $transferencia = Transferencia::findOrFail($id);

        if ($transferencia->estado !== 'pendiente') {
            return redirect()->route('transferencias.index')->with('error', 'Solo se pueden eliminar transferencias pendientes.');
        }

        $transferencia->delete();

        return redirect()->route('transferencias.index')->with('success', 'Transferencia eliminada correctamente.');
    }

    public function show($id)
    {
        $transferencia = Transferencia::with('fauna')->findOrFail($id);
        return view('transferencias.show', compact('transferencia'));
    }

    public function pdf($id)
    {
        $transferencia = Transferencia::with('fauna')->findOrFail($id);
        $userInstitucionId = Auth::user()->institucion_id;

        if ($userInstitucionId != $transferencia->institucion_origen) {
            return redirect()->route('transferencias.index')->with('error', 'No tienes permiso para descargar este PDF.');
        }

        $pdf = Pdf::loadView('transferencias.pdf', compact('transferencia'));
        return $pdf->download('transferencia_' . $id . '.pdf');
    }

    public function aceptar($id)
    {
        $transferencia = Transferencia::with('fauna.historialesClinicos', 'fauna.documentos')->findOrFail($id);
        $user = Auth::user();

        if ($user->institucion_id !== $transferencia->institucion_destino) {
            return redirect()->route('transferencias.index')->with('error', 'No tienes permiso para realizar esta acción.');
        }

        if ($transferencia->estado !== 'pendiente') {
            return redirect()->route('transferencias.index')->with('error', 'Solo se pueden aceptar solicitudes pendientes.');
        }

        DB::transaction(function () use ($transferencia, $user) {
            $transferencia->update([
                'estado' => 'aceptado',
                'fecha_transferencia' => now(),
            ]);

            $faunaOriginal = $transferencia->fauna;

            // Clonar fauna
            $nuevoFauna = $faunaOriginal->replicate();
            $nuevoFauna->codigo = $faunaOriginal->codigo . '-T' . $transferencia->id;
            $nuevoFauna->fecha_ingreso = now();
            $nuevoFauna->fecha_recepcion = now();
            $nuevoFauna->institucion_remitente = $transferencia->institucion_origen;
            $nuevoFauna->institucion = $transferencia->institucion_destino;
            $nuevoFauna->user_id = $user->id;

            if ($faunaOriginal->foto && Storage::disk('public')->exists($faunaOriginal->foto)) {
                $ext = pathinfo($faunaOriginal->foto, PATHINFO_EXTENSION);
                $rutaNueva = 'faunas/' . uniqid('foto_') . '.' . $ext;
                Storage::disk('public')->copy($faunaOriginal->foto, $rutaNueva);
                $nuevoFauna->foto = $rutaNueva;
            }

            $nuevoFauna->save();

            // Clonar historiales clínicos
            foreach ($faunaOriginal->historialesClinicos as $historial) {
                $nuevoHistorial = $historial->replicate();
                $nuevoHistorial->fauna_id = $nuevoFauna->id;

                if ($historial->foto_animal && Storage::disk('public')->exists($historial->foto_animal)) {
                    $ext = pathinfo($historial->foto_animal, PATHINFO_EXTENSION);
                    $rutaNueva = 'historiales/' . uniqid('animal_') . '.' . $ext;
                    Storage::disk('public')->copy($historial->foto_animal, $rutaNueva);
                    $nuevoHistorial->foto_animal = $rutaNueva;
                }

                $nuevoHistorial->save();
            }

            // Clonar documentos
            foreach ($faunaOriginal->documentos as $documento) {
                $nuevoDocumento = $documento->replicate();
                $nuevoDocumento->fauna_id = $nuevoFauna->id;

                if ($documento->ruta && Storage::disk('public')->exists($documento->ruta)) {
                    $ext = pathinfo($documento->ruta, PATHINFO_EXTENSION);
                    $nuevaRuta = 'documentos/' . uniqid('doc_') . '.' . $ext;
                    Storage::disk('public')->copy($documento->ruta, $nuevaRuta);
                    $nuevoDocumento->ruta = $nuevaRuta;
                }

                $nuevoDocumento->save();
            }

            HistorialTransferencia::create([
                'fauna_id' => $nuevoFauna->id,
                'transferencia_id' => $transferencia->id,
                'institucion_origen' => $transferencia->institucion_origen,
                'institucion_destino' => $transferencia->institucion_destino,
                'fecha_transferencia' => $transferencia->fecha_transferencia,
                'motivo' => $transferencia->motivo,
                'observaciones' => $transferencia->observaciones,
            ]);
        });

        return redirect()->route('transferencias.index')->with('success', 'Transferencia aceptada y fauna registrada correctamente.');
    }

    public function rechazar($id)
    {
        $transferencia = Transferencia::findOrFail($id);
        $user = Auth::user();

        if ($user->institucion_id !== $transferencia->institucion_destino) {
            return redirect()->route('transferencias.index')->with('error', 'No tienes permiso para realizar esta acción.');
        }

        if ($transferencia->estado !== 'pendiente') {
            return redirect()->route('transferencias.index')->with('error', 'Solo se pueden rechazar solicitudes pendientes.');
        }

        $transferencia->update(['estado' => 'rechazado']);

        return redirect()->route('transferencias.index')->with('success', 'Transferencia rechazada.');
    }

    public function recepciones()
    {
        $user = Auth::user();

        if (!$user->institucion_id) {
            abort(403, 'Tu usuario no tiene una institución asignada.');
        }

        $transferencias = Transferencia::where('institucion_destino', $user->institucion_id)
            ->where('estado', 'aceptado')
            ->with('fauna')
            ->get();

        $faunas = Fauna::where('institucion', $user->institucion_id)->get();

        return view('recepciones.index', compact('transferencias', 'faunas'));
    }

    public function changeStatus(Request $request, $id)
    {
        $transferencia = Transferencia::findOrFail($id);
        $nuevoEstado = $request->input('estado');

        if (!in_array($nuevoEstado, ['aceptado', 'rechazado'])) {
            return redirect()->back()->with('error', 'Estado inválido.');
        }

        $transferencia->estado = $nuevoEstado;
        $transferencia->save();

        return redirect()->route('transferencias.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function reportePdf()
    {
        $user = Auth::user();

        $faunaRegistradaIds = Fauna::where('user_id', $user->id)->pluck('id');
        $faunaTransferidaIds = Transferencia::where('institucion_destino', $user->institucion_id)->pluck('fauna_id');

        $faunaIds = $faunaRegistradaIds->merge($faunaTransferidaIds)->unique();

        $transferencias = Transferencia::with(['fauna', 'institucionOrigen', 'institucionDestino'])
            ->whereIn('fauna_id', $faunaIds)
            ->latest()
            ->get();

        $pdf = PDF::loadView('transferencias.reportPdf', compact('transferencias'));

        return $pdf->download('reporte_transferencias.pdf');
    }

    public function reporteExcel()
    {
        return Excel::download(new TransferenciasExport(Auth::user()), 'reporte_transferencias.xlsx');
    }
}
