<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parte;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PartesExport;  // Importar la clase exportadora

class ParteController extends Controller
{
    public function index(Request $request)
{
    $query = Parte::query();

    if (Auth::check()) {
        $user = Auth::user();
        $userInstitution = $user->institucion->nombre ?? null;

        if ($userInstitution) {
            $query->whereRaw('LOWER(institucion_remitente) = ?', [strtolower($userInstitution)]);
        } else {
            // Si no hay institución, quizás mostrar nada o todos (ajustar según lógica)
            $query->whereRaw('1 = 0'); // no muestra nada
        }
    }

    if ($request->filled('tipo_registro')) {
        $query->where('tipo_registro', $request->tipo_registro);
    }

    $partes = $query->latest()->paginate(10);

    return view('partes.index', compact('partes'));
}


    public function create()
    {
        $user = Auth::user();
        $institucionNombre = $user->institucion->nombre ?? 'SIN-INST';
        $iniciales = $this->obtenerIniciales($institucionNombre);
        $anio = date('Y');

        $ultimoParte = Parte::where('codigo', 'like', "$iniciales-P-%-$anio")
            ->orderByDesc('id')
            ->first();

        $nuevoNumero = $ultimoParte
            ? str_pad((int)explode('-', $ultimoParte->codigo)[2] + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $codigoGenerado = "$iniciales-P-$nuevoNumero-$anio";

        return view('partes.create', compact('codigoGenerado', 'institucionNombre'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:255|unique:partes,codigo',
            'tipo_registro' => 'required|string|in:animal_muerto,parte,derivado',
            'fecha_recepcion' => 'required|date',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'coordenadas' => 'nullable|string|max:100',
            'institucion_remitente' => 'required|string|max:255',
            'nombre_persona_recibe' => 'required|string|max:255',
            'tipo_elemento' => 'nullable|string|max:50',
            'motivo_ingreso' => 'nullable|string|max:1000',
            'cantidad' => 'required|integer|min:1',
            'especie' => 'required|string|max:100',
            'nombre_comun' => 'nullable|string|max:100',
            'tipo_animal' => 'nullable|string|max:50',
            'fecha' => 'required|date',
            'disposicion_final' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('partes_fotos', 'public');
            $validated['foto'] = basename($fotoPath);
        }

        $validated['institucion'] = Auth::user()->institucion->nombre ?? 'SIN-INST';
        $validated['user_id'] = Auth::id();

        Parte::create($validated);

        return redirect()->route('partes.index')
                         ->with('success', 'Parte registrada correctamente.');
    }

    public function show(Parte $parte)
    {
        return view('partes.show', compact('parte'));
    }

    public function edit(Parte $parte)
    {
        return view('partes.edit', compact('parte'));
    }

    public function update(Request $request, Parte $parte)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:255|unique:partes,codigo,' . $parte->id,
            'tipo_registro' => 'required|string|in:animal_muerto,parte,derivado',
            'fecha_recepcion' => 'required|date',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'coordenadas' => 'nullable|string|max:100',
            'institucion_remitente' => 'required|string|max:255',
            'nombre_persona_recibe' => 'required|string|max:255',
            'tipo_elemento' => 'nullable|string|max:50',
            'motivo_ingreso' => 'nullable|string|max:1000',
            'cantidad' => 'required|integer|min:1',
            'especie' => 'required|string|max:100',
            'nombre_comun' => 'nullable|string|max:100',
            'tipo_animal' => 'nullable|string|max:50',
            'fecha' => 'required|date',
            'disposicion_final' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($parte->foto) {
                Storage::disk('public')->delete($parte->foto);
            }
            $validated['foto'] = $request->file('foto')->store('partes_fotos', 'public');
        }

        $validated['institucion'] = Auth::user()->institucion->nombre ?? $parte->institucion;

        $parte->update($validated);

        return redirect()->route('partes.index')
                         ->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(Parte $parte)
    {
        if ($parte->foto) {
            Storage::disk('public')->delete($parte->foto);
        }
        $parte->delete();

        return redirect()->route('partes.index')
                         ->with('success', 'Registro eliminado correctamente.');
    }

    private function obtenerIniciales($nombre)
    {
        return collect(explode(' ', strtoupper($nombre)))
            ->filter()
            ->map(fn($palabra) => substr($palabra, 0, 1))
            ->implode('');
    }

    public function generarPDF($id)
    {
        $parte = Parte::findOrFail($id);

        $pdf = Pdf::loadView('partes.pdf_individual', compact('parte'))
                  ->setPaper('letter', 'portrait');

        return $pdf->download('parte_' . $parte->codigo . '.pdf');
    }

    // En tu controlador:
public function exportExcel(Request $request)
{
    $filtros = $request->only(['codigo', 'fecha_inicio', 'fecha_fin']);

    $user = Auth::user();
    $filtros['institucion'] = $user->institucion->nombre ?? null;

    $filename = 'partes_' . now()->format('Ymd_His') . '.xlsx';

    return Excel::download(new PartesExport($filtros), $filename);
}

    public function exportPdf(Request $request)
{
    $filtros = $request->only(['codigo', 'fecha_inicio', 'fecha_fin']);

    $user = Auth::user();
    $institucion = $user->institucion->nombre ?? null;

    $query = Parte::query();

    if ($institucion) {
        $query->whereRaw('LOWER(institucion_remitente) = ?', [strtolower($institucion)]);
    }

    if (!empty($filtros['codigo'])) {
        $query->where('codigo', 'like', '%' . $filtros['codigo'] . '%');
    }
    if (!empty($filtros['fecha_inicio'])) {
        $query->whereDate('fecha_recepcion', '>=', $filtros['fecha_inicio']);
    }
    if (!empty($filtros['fecha_fin'])) {
        $query->whereDate('fecha_recepcion', '<=', $filtros['fecha_fin']);
    }

    $partes = $query->get();

    $pdf = Pdf::loadView('partes.report', compact('partes'))
        ->setPaper('letter', 'landscape');

    return $pdf->download('partes_' . now()->format('Ymd_His') . '.pdf');
}


    public function duplicar($id)
{
    $registroOriginal = Parte::findOrFail($id);

    $registroClonado = $registroOriginal->replicate();
    $registroClonado->codigo = null;
    $registroClonado->foto = null;
    $registroClonado->created_at = null;
    $registroClonado->updated_at = null;

    // Generar un nuevo código si quieres automático:
    $user = Auth::user();
    $institucionNombre = $user->institucion->nombre ?? 'SIN-INST';
    $iniciales = $this->obtenerIniciales($institucionNombre);
    $anio = date('Y');

    $ultimoParte = Parte::where('codigo', 'like', "$iniciales-P-%-$anio")
        ->orderByDesc('id')
        ->first();

    $nuevoNumero = $ultimoParte
        ? str_pad((int)explode('-', $ultimoParte->codigo)[2] + 1, 4, '0', STR_PAD_LEFT)
        : '0001';

    $codigoGenerado = "$iniciales-P-$nuevoNumero-$anio";

    return view('partes.create', [
        'registroDuplicado' => $registroClonado,
        'codigoGenerado' => $codigoGenerado,
        'institucionNombre' => $institucionNombre,
    ]);
}

}
