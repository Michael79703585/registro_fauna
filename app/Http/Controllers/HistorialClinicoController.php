<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Fauna;
use App\Models\Transferencia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistorialClinicoExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HistorialClinicoController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $faunaIdSeleccionado = $request->get('fauna_id');

        $faunaPropiaIds = Fauna::whereHas('user', function ($query) use ($user) {
            $query->where('institucion_id', $user->institucion_id);
        })->pluck('id');

        $faunaTransferidaIds = Transferencia::where('institucion_destino', $user->institucion_id)
                                            ->pluck('fauna_id');

        $faunaIds = $faunaPropiaIds->merge($faunaTransferidaIds)->unique();

        $faunas = Fauna::whereIn('id', $faunaIds)
                       ->select('id','codigo','nombre_comun')
                       ->orderBy('codigo')
                       ->get();

        return view('historial.create', compact('faunas','faunaIdSeleccionado'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        abort_if(!$user, 403, 'Acceso denegado');

        $faunaAutorizada = $this->obtenerFaunaAutorizada($user);

        $query = HistorialClinico::whereIn('fauna_id', $faunaAutorizada)
            ->with('fauna.ultimaTransferencia')
            ->when($request->filled('buscar'), fn($q) =>
                $q->whereHas('fauna', fn($sub) =>
                    $sub->where('codigo','like','%'.$request->buscar.'%')
                        ->orWhere('nombre_comun','like','%'.$request->buscar.'%')
                )
            )
            ->orderByDesc('fecha');

        $historiales = $query->paginate(10);

        return view('historial.index', compact('historiales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fauna_id' => 'required|exists:faunas,id',
            'fecha' => 'required|date',
            'examen_general' => 'nullable|array',
            'examen_general.*' => 'nullable|string',
            'etologia' => 'nullable|string',
            'diagnostico' => 'required|string|max:255',
            'tratamiento' => 'nullable|string',
            'nutricion' => 'nullable|string',
            'pruebas_laboratorio' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'foto_animal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_base64' => 'nullable|string|starts_with:data:image/',
            'archivo_laboratorio' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data['examen_general'] = $request->examen_general ? json_encode($request->examen_general) : null;
        $data['foto_animal'] = $this->handleImageUpload($request);
        $data['archivo_laboratorio'] = $this->handleFileUpload($request,'archivo_laboratorio','laboratorios');

        HistorialClinico::create($data);

        return $request->has('redirigir_a_ficha')
            ? redirect()->route('fauna.show',$data['fauna_id'])->with('success','Historial registrado.')
            : redirect()->route('historial.index')->with('success','Historial creado.');
    }

    public function show($id)
{
    $historial = HistorialClinico::with('fauna')->findOrFail($id);
    $this->authorizeView($historial);  // <-- Aquí
    return view('historial.show', compact('historial'));
}


    public function edit($id)
    {
        $historial = HistorialClinico::with('fauna')->findOrFail($id);
        $this->authorizeInstitution($historial);

        $faunas = Fauna::whereHas('user', function($query) use ($historial) {
            $query->where('institucion_id', $historial->fauna->user->institucion_id);
        })->get();

        return view('historial.edit', compact('historial','faunas'));
    }

    public function update(Request $request,$id)
    {
        $historial = HistorialClinico::with('fauna')->findOrFail($id);
        $this->authorizeInstitution($historial);

        $data = $request->validate([
            'fauna_id' => 'required|exists:faunas,id',
            'fecha' => 'required|date',
            'examen_general' => 'nullable|array',
            'examen_general.*' => 'nullable|string',
            'etologia' => 'nullable|string',
            'diagnostico' => 'required|string|max:255',
            'tratamiento' => 'nullable|string',
            'nutricion' => 'nullable|string',
            'pruebas_laboratorio' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'foto_animal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_base64' => 'nullable|string|starts_with:data:image/',
            'archivo_laboratorio' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data['examen_general'] = $request->examen_general ? json_encode($request->examen_general) : null;

        if ($request->hasFile('foto_animal') || $request->filled('foto_base64')) {
            $this->deleteFileIfExists($historial->foto_animal);
            $data['foto_animal'] = $this->handleImageUpload($request);
        }

        if ($request->hasFile('archivo_laboratorio')) {
            $this->deleteFileIfExists($historial->archivo_laboratorio);
            $data['archivo_laboratorio'] = $this->handleFileUpload($request,'archivo_laboratorio','laboratorios');
        }

        $historial->update($data);
        return redirect()->route('historial.index')->with('success','Historial actualizado.');
    }

    public function destroy($id)
    {
        $historial = HistorialClinico::with('fauna')->findOrFail($id);
        $this->authorizeInstitution($historial);

        $this->deleteFileIfExists($historial->foto_animal);
        $this->deleteFileIfExists($historial->archivo_laboratorio);
        $historial->delete();

        return redirect()->route('historial.index')->with('success','Historial eliminado.');
    }

 public function exportarPDF($id)
{
    $historial = HistorialClinico::with('fauna')->findOrFail($id);
    $this->authorizeView($historial);  // <-- Aquí
    $pdf = Pdf::loadView('historial.pdf', compact('historial'));
    return $pdf->download("historial_clinico_{$historial->id}.pdf");
}

    public function reportePdf(Request $request)
{
    $buscar = $request->input('buscar');
    $user = Auth::user();

    // Animales autorizados por institución (propios o transferidos)
    $faunaIds = $this->obtenerFaunaAutorizada($user);

    $historiales = HistorialClinico::with('fauna')
        ->whereIn('fauna_id', $faunaIds)
        ->when($buscar, fn($query) => 
            $query->whereHas('fauna', fn($q) =>
                $q->where('codigo', 'like', "%$buscar%")
                  ->orWhere('nombre_comun', 'like', "%$buscar%")
            )
        )
        ->orderByDesc('fecha')
        ->get();

    $pdf = Pdf::loadView('historial.reporte-pdf', compact('historiales'))
        ->setPaper('letter', 'landscape')
        ->setOptions([
            'margin-top' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'margin-right' => 10,
        ]);

    return $pdf->download('reporte_historiales.pdf');
}

    public function reporteExcel(Request $request)
    {
        $buscar = $request->input('buscar');
        $user = Auth::user();

        return Excel::download(new HistorialClinicoExport($buscar, $user), 'reporte_historial.xlsx');
    }

    public function duplicate($id)
    {
        $original = HistorialClinico::findOrFail($id);
        $this->authorizeInstitution($original);
        $nuevo = $original->replicate();
        $nuevo->fecha = now();
        $nuevo->diagnostico .= ' (copia)';
        $nuevo->save();

        return redirect()->route('historial.edit', $nuevo->id)->with('success', 'Historial duplicado.');
    }

    public function descargarArchivo($id)
    {
        $historial = HistorialClinico::findOrFail($id);
        $this->authorizeInstitution($historial);
        $ruta = $historial->archivo_laboratorio;

        abort_if(!$ruta || !Storage::disk('public')->exists(str_replace('storage/', '', $ruta)), 404, 'Archivo no encontrado.');

        return response()->file(storage_path('app/public/' . str_replace('storage/', '', $ruta)));
    }

    public function destroyFauna($id)
    {
        $fauna = Fauna::findOrFail($id);
        $this->authorizeInstitutionForFauna($fauna);
        $fauna->delete();
        return redirect()->route('fauna.index')->with('success', 'Animal eliminado correctamente.');
    }
 

   // MÉTODOS PRIVADOS

private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('foto_animal')) {
            $path = $request->file('foto_animal')->store('fotos_animales', 'public');
            return 'storage/' . $path;
        }

        if ($request->filled('foto_base64') && preg_match('/^data:image\/(\w+);base64,/', $request->foto_base64, $matches)) {
            $data = base64_decode(substr($request->foto_base64, strpos($request->foto_base64, ',') + 1));
            $ext = strtolower($matches[1]);
            if (!in_array($ext, ['jpeg', 'jpg', 'png'])) return null;

            $filename = 'foto_' . time() . '.' . $ext;
            $relativePath = 'fotos_animales/' . $filename;
            Storage::disk('public')->put($relativePath, $data);
            return 'storage/' . $relativePath;
        }

        return null;
    }

    private function handleFileUpload(Request $request, $input, $folder): ?string
    {
        if ($request->hasFile($input)) {
            $file = $request->file($input);
            $name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($folder, $name, 'public');
            return 'storage/' . $path;
        }
        return null;
    }

    private function deleteFileIfExists(?string $path)
    {
        if ($path) {
            $internalPath = str_replace('storage/', '', $path);
            if (Storage::disk('public')->exists($internalPath)) {
                Storage::disk('public')->delete($internalPath);
            }
        }
    }

    private function authorizeInstitution(HistorialClinico $historial)
    {
        $user = Auth::user();
        $fauna = $historial->fauna;

        if (!$fauna) abort(403, 'No se encontró el animal relacionado.');

        $transferenciaActual = Transferencia::where('fauna_id', $fauna->id)
            ->orderByDesc('fecha_transferencia')
            ->first();

        if ($transferenciaActual) {
            if ($transferenciaActual->institucion_destino != $user->institucion_id) {
                abort(403, 'No tienes permiso para modificar o eliminar este historial.');
            }
        } else {
            if ($fauna->user->institucion_id != $user->institucion_id) {
                abort(403, 'No tienes permiso para modificar o eliminar este historial.');
            }
        }
    }

    private function authorizeView(HistorialClinico $historial): void
    {
        $user = Auth::user();
        $fauna = $historial->fauna;

        if (!$fauna) {
            abort(403, 'No se encontró el animal relacionado.');
        }

        $institucionUser = $user->institucion_id;

        $institucionOrigen = $fauna->user->institucion_id;

        $institucionesDestino = Transferencia::where('fauna_id', $fauna->id)
            ->pluck('institucion_destino')
            ->toArray();

        $institucionesOrigenTransferencia = Transferencia::where('fauna_id', $fauna->id)
            ->pluck('institucion_origen')
            ->toArray();

        $institucionesAutorizadas = array_unique(array_merge(
            [$institucionOrigen],
            $institucionesDestino,
            $institucionesOrigenTransferencia
        ));

        if (!in_array($institucionUser, $institucionesAutorizadas)) {
            abort(403, 'No tienes permiso para visualizar o descargar este historial.');
        }
    }

    private function obtenerFaunaAutorizada($user)
{
    $faunaIds = Fauna::query()
        ->whereHas('user', function ($query) use ($user) {
            $query->where('institucion_id', $user->institucion_id);
        })
        ->pluck('id')
        ->toArray();

    $faunaTransferida = Transferencia::where('institucion_destino', $user->institucion_id)
        ->pluck('fauna_id')
        ->toArray();

    $faunaHistorial = Transferencia::whereIn('institucion_destino', [$user->institucion_id])
        ->pluck('fauna_id')
        ->toArray();

    return collect(array_unique(array_merge($faunaIds, $faunaTransferida, $faunaHistorial)));
}


    private function authorizeInstitutionForFauna(Fauna $fauna)
    {
        $user = Auth::user();

        if (!$fauna) {
            abort(403, 'No se encontró el animal.');
        }

        if ($fauna->user && $fauna->user->institucion_id == $user->institucion_id) {
            return;
        }

        $transferenciaActual = Transferencia::where('fauna_id', $fauna->id)
            ->orderByDesc('fecha_transferencia')
            ->first();

        if ($transferenciaActual && $transferenciaActual->institucion_destino == $user->institucion_id) {
            return;
        }

        abort(403, 'No tienes permiso para acceder a este animal.');
    }
}