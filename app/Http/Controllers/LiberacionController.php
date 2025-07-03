<?php

namespace App\Http\Controllers;

use App\Models\Liberacion;
use App\Models\Fauna;                  // <-- Importar Fauna
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LiberacionExport;
use App\Models\Transferencia;
class LiberacionController extends Controller
{

public function index(Request $request)
{
    $user = Auth::user();

    // Filtrar liberaciones solo del usuario logueado
    $query = Liberacion::where('user_id', $user->id);

    // Filtros opcionales
    if ($request->filled('codigo')) {
        $query->where('codigo', 'like', '%' . $request->codigo . '%');
    }

    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha', '>=', $request->fecha_inicio);
    }

    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha', '<=', $request->fecha_fin);
    }

    $liberaciones = $query->orderByDesc('fecha')->paginate(10);

    return view('liberaciones.index', compact('liberaciones'))
           ->with('filters', $request->all());
}

public function create()
{
    $user = Auth::user();

    // Obtener fauna registrada por el usuario o transferida a su institución
    $faunaRegistradaIds = Fauna::where('user_id', $user->id)->pluck('id');
    $faunaTransferidaIds = Transferencia::where('institucion_destino', $user->institucion_id)->pluck('fauna_id');
    $faunaIds = $faunaRegistradaIds->merge($faunaTransferidaIds)->unique();

    $faunas = Fauna::whereIn('id', $faunaIds)
        ->select('id', 'codigo')
        ->orderBy('codigo')
        ->get();

    return view('liberaciones.create', compact('faunas'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'fauna_id'         => 'required|exists:faunas,id',
        'fecha'            => 'required|date',
        'lugar_liberacion' => 'required|string|max:255',
        'departamento'     => 'required|string|max:100',
        'municipio'        => 'required|string|max:100',
        'coordenadas'      => 'nullable|string|max:100',
        'responsable'      => 'required|string|max:100',
        'observaciones'    => 'nullable|string|max:1000',
        'foto'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $animal = Fauna::find($validated['fauna_id']);

    if (!$animal) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['fauna_id' => 'Animal no encontrado.']);
    }

    $validated['tipo_animal']  = $animal->tipo_animal;
    $validated['especie']      = $animal->especie;
    $validated['nombre_comun'] = $animal->nombre_comun;
    $validated['institucion']  = Auth::user()->institucion->nombre ?? 'Sin institución';
    $validated['user_id']      = Auth::id();

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('liberaciones_fotos', 'public');
    }

    do {
        $nuevoCodigo = $animal->codigo . '-' . now()->format('YmdHis');
    } while (Liberacion::where('codigo', $nuevoCodigo)->exists());

    $validated['codigo'] = $nuevoCodigo;

    Liberacion::create($validated);

    return redirect()->route('liberaciones.index')->with('success', 'Liberación registrada exitosamente.');
}


    public function show(Liberacion $liberacion)
    {
        return view('liberaciones.show', compact('liberacion'));
    }

    public function edit(Liberacion $liberacion)
    {
        // Para editar, no necesitamos recargar la lista de códigos porque asumimos
        // que no cambia el “código” de liberación. 
        return view('liberaciones.edit', compact('liberacion'));
    }

    public function update(Request $request, Liberacion $liberacion)
{
    $validated = $request->validate([
        'fauna_id'         => 'required|exists:faunas,id',
        'fecha'            => 'required|date',
        'lugar_liberacion' => 'required|string|max:255',
        'departamento'     => 'required|string|max:100',
        'municipio'        => 'required|string|max:100',
        'coordenadas'      => 'nullable|string|max:100',
        'responsable'      => 'required|string|max:100',
        'observaciones'    => 'nullable|string|max:1000',
        'foto'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Obtener el nuevo animal por ID
    $animal = Fauna::find($validated['fauna_id']);

    if (!$animal) {
        return redirect()->back()
                         ->withInput()
                         ->withErrors(['fauna_id' => 'Animal no encontrado.']);
    }

    // Actualizar datos heredados del animal
    $validated['tipo_animal']  = $animal->tipo_animal;
    $validated['especie']      = $animal->especie;
    $validated['nombre_comun'] = $animal->nombre_comun;

    // Si hay una nueva foto, reemplazar
    if ($request->hasFile('foto')) {
        if ($liberacion->foto) {
            Storage::disk('public')->delete($liberacion->foto);
        }
        $validated['foto'] = $request->file('foto')->store('liberaciones_fotos', 'public');
    }

    // Asegurar que se mantiene la institución actual del usuario o la previa
    $validated['institucion'] = Auth::user()->institucion->nombre ?? $liberacion->institucion;

    // Actualizamos el registro
    $liberacion->update($validated);

    return redirect()->route('liberaciones.index')
                     ->with('success', 'Liberación actualizada correctamente.');
}

    public function destroy(Liberacion $liberacion)
    {
        if ($liberacion->foto) {
            Storage::disk('public')->delete($liberacion->foto);
        }
        $liberacion->delete();

        return redirect()->route('liberaciones.index')
                         ->with('success', 'Registro eliminado correctamente.');
    }

    public function exportPdf(Request $request)
{
    $query = Liberacion::query();

    // Filtrar por usuario logueado
    $query->where('user_id', Auth::id());

    // Filtros adicionales
    if ($request->filled('codigo')) {
        $query->where('codigo', 'like', '%' . $request->codigo . '%');
    }
    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha', '>=', $request->fecha_inicio);
    }
    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha', '<=', $request->fecha_fin);
    }

    $liberaciones = $query->orderByDesc('fecha')->get();
    $pdf = Pdf::loadView('liberaciones.pdf', compact('liberaciones'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('liberaciones.pdf');
}

public function exportExcel(Request $request)
{
    $filters = $request->all();
    $filters['user_id'] = Auth::id(); // 👈 Agregar el filtro por usuario

    return Excel::download(new LiberacionExport($filters), 'liberaciones.xlsx');
}


    // Ruta AJAX: devuelve JSON con datos de fauna según código
    public function buscarPorCodigo($codigo)
    {
        $animal = Fauna::where('codigo', $codigo)->first();

        if ($animal) {
            return response()->json([
                'success' => true,
                'data' => [
                    'tipo_animal'  => $animal->tipo_animal,
                    'especie'      => $animal->especie,
                    'nombre_comun' => $animal->nombre_comun,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Código no encontrado'
        ], 404);
    }
    public function exportPdfIndividual(Liberacion $liberacion)
{
    $pdf = Pdf::loadView('liberaciones.pdf_individual', compact('liberacion'))
              ->setPaper('letter', 'portrait');

    return $pdf->download('liberacion_' . $liberacion->codigo . '.pdf');
}
}
