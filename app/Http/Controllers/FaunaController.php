<?php

namespace App\Http\Controllers;

use App\Models\Fauna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FaunasExport;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FaunaController extends Controller
{
    public function index(Request $request)
{
    $query = Fauna::query();

    if (Auth::check()) {
        $userInstitution = Auth::user()->institucion->nombre ?? null;
        if ($userInstitution) {
            $query->whereRaw('LOWER(institucion_remitente) = ?', [strtolower($userInstitution)]);
        }
    }

    if ($request->filled('codigo')) {
        $query->where('codigo', 'like', '%' . $request->codigo . '%');
    }

    // Filtros de fechas incluyendo registros sin fecha_recepcion
    if ($request->filled('fecha_inicio')) {
        $query->where(function($q) use ($request) {
            $q->whereNull('fecha_recepcion')
              ->orWhereDate('fecha_recepcion', '>=', $request->fecha_inicio);
        });
    }

    if ($request->filled('fecha_fin')) {
        $query->where(function($q) use ($request) {
            $q->whereNull('fecha_recepcion')
              ->orWhereDate('fecha_recepcion', '<=', $request->fecha_fin);
        });
    }

    if ($request->filled('gestion')) {
        $query->where(function($q) use ($request) {
            $q->whereNull('fecha_recepcion')
              ->orWhereYear('fecha_recepcion', $request->gestion);
        });
    }

    // Ordenar por fecha_recepcion para que se vea más claro (NULLs primero)
    $query->orderByRaw('fecha_recepcion IS NULL DESC')->latest('fecha_recepcion');

    $faunas = $query->paginate(10);

    $gestiones = Fauna::selectRaw('YEAR(fecha_recepcion) as year')
        ->whereNotNull('fecha_recepcion')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    return view('fauna.index', compact('faunas', 'gestiones'));
}


    public function create()
    {
        return view('fauna.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'fecha_ingreso' => 'required|date',
        'fecha_recepcion' => 'required|date',
        'ciudad' => 'nullable|string|max:100',
        'departamento' => 'nullable|string|max:100',
        'coordenadas' => 'nullable|string|max:100',
        'tipo_elemento' => 'nullable|string|max:50',
        'motivo_ingreso' => 'nullable|string|max:50',
        'lugar' => 'nullable|string|max:100',
        'institucion_remitente' => 'nullable|string|max:100',
        'nombre_persona_recibe' => 'nullable|string|max:100',
        'especie' => 'required|string|max:100',
        'nombre_comun' => 'nullable|string|max:100',
        'tipo_animal' => 'nullable|string|max:50',
        'edad_aparente' => 'nullable|string|max:50',
        'estado_general' => 'nullable|string|max:100',
        'sexo' => 'required|string|max:20',
        'comportamiento' => 'nullable|string|max:50',
        'sospecha_enfermedad' => 'nullable|string|in:SI,NO',
        'descripcion_enfermedad' => 'nullable|string',
        'alteraciones_evidentes' => 'nullable|string',
        'otras_observaciones' => 'nullable|string',
        'tiempo_cautiverio' => 'nullable|string|max:100',
        'tipo_alojamiento' => 'nullable|string|max:100',
        'contacto_con_animales' => 'nullable|string|in:SI,NO',
        'descripcion_contacto' => 'nullable|string',
        'padecio_enfermedad' => 'nullable|string|in:SI,NO',
        'descripcion_padecimiento' => 'nullable|string',
        'tipo_alimentacion' => 'nullable|string',
        'derivacion_ccfs' => 'nullable|string|in:SI,NO',
        'descripcion_derivacion' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
    ]);

    // Guardar archivo de foto
    $validated['foto'] = $request->hasFile('foto') ? $request->file('foto')->store('fotos', 'public') : null;
    $validated['user_id'] = Auth::id();
    $validated['codigo'] = 'FAU-' . strtoupper(Str::random(6));

    // Convertir campos de SI/NO a booleanos
    $validated['sospecha_enfermedad'] = $request->sospecha_enfermedad === 'SI' ? 1 : 0;
    $validated['contacto_con_animales'] = $request->contacto_con_animales === 'SI' ? 1 : 0;
    $validated['padecio_enfermedad'] = $request->padecio_enfermedad === 'SI' ? 1 : 0;
    $validated['derivacion_ccfs'] = $request->derivacion_ccfs === 'SI' ? 1 : 0;


   // 1. Sacar las iniciales
    $inst = $validated['institucion_remitente'];
    $initials = Fauna::getInstitutionInitials($inst);

    // 2. Año de registro (puede ser de recepcion o ahora)
    $year = Carbon::parse($validated['fecha_recepcion'])->year;

    // 3. Buscar cuántos hay para esa institución y año
    $count = Fauna::where('institucion_remitente', $inst)
                  ->whereYear('fecha_recepcion', $year)
                  ->count();

    // 4. Secuencial = siguiente +1 y padded a 4 dígitos
    $seq = str_pad($count + 1, 4, '0', STR_PAD_LEFT);

    // 5. Montar el código
    $validated['codigo'] = "{$initials}-FAU-{$seq}-{$year}";

    Fauna::create($validated);

    return redirect()->route('fauna.index')->with('success', 'Registro guardado correctamente.');
}

    public function show($id)
    {
        $fauna = Fauna::findOrFail($id);
        return view('fauna.show', compact('fauna'));
    }

    public function edit($id)
    {
        $fauna = Fauna::findOrFail($id);
        return view('fauna.edit', compact('fauna'));
    }

   public function update(Request $request, $id)
{
    $fauna = Fauna::findOrFail($id);

    $validated = $request->validate([
        'fecha_recepcion' => 'required|date',
        'ciudad' => 'nullable|string|max:100',
        'departamento' => 'nullable|string|max:100',
        'coordenadas' => 'nullable|string|max:100',
        'tipo_elemento' => 'nullable|string|max:50',
        'motivo_ingreso' => 'nullable|string|max:50',
        'lugar' => 'nullable|string|max:100',
        'institucion_remitente' => 'nullable|string|max:100',
        'nombre_persona_recibe' => 'nullable|string|max:100',
        'especie' => 'required|string|max:100',
        'nombre_comun' => 'nullable|string|max:100',
        'tipo_animal' => 'nullable|string|max:50',
        'edad_aparente' => 'nullable|string|max:50',
        'estado_general' => 'nullable|string|max:100',
        'sexo' => 'required|string|max:20',
        'comportamiento' => 'nullable|string|max:50',
        'sospecha_enfermedad' => 'nullable|string|in:SI,NO',
        'descripcion_enfermedad' => 'nullable|string',
        'alteraciones_evidentes' => 'nullable|string',
        'otras_observaciones' => 'nullable|string',
        'tiempo_cautiverio' => 'nullable|string|max:100',
        'tipo_alojamiento' => 'nullable|string|max:100',
        'contacto_con_animales' => 'nullable|string|in:SI,NO',
        'descripcion_contacto' => 'nullable|string',
        'padecio_enfermedad' => 'nullable|string|in:SI,NO',
        'descripcion_padecimiento' => 'nullable|string',
        'tipo_alimentacion' => 'nullable|string',
        'derivacion_ccfs' => 'nullable|string|in:SI,NO',
        'descripcion_derivacion' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
    ]);

    // Convertir campos de SI/NO a booleanos
    $validated['sospecha_enfermedad'] = $request->sospecha_enfermedad === 'SI' ? 1 : 0;
    $validated['contacto_con_animales'] = $request->contacto_con_animales === 'SI' ? 1 : 0;
    $validated['padecio_enfermedad'] = $request->padecio_enfermedad === 'SI' ? 1 : 0;
    $validated['derivacion_ccfs'] = $request->derivacion_ccfs === 'SI' ? 1 : 0;

    if ($request->hasFile('foto')) {
        if ($fauna->foto) {
            Storage::disk('public')->delete($fauna->foto);
        }
        $validated['foto'] = $request->file('foto')->store('fotos', 'public');
    }

    $fauna->update($validated);

    return redirect()->route('fauna.index')->with('success', 'Registro actualizado correctamente.');
}

    public function exportPDF($id)
    {
        $fauna = Fauna::findOrFail($id);
        $pdf = PDF::loadView('fauna.pdf', compact('fauna'))->setPaper('letter', 'landscape');
        return $pdf->download('ficha_fauna_' . $fauna->codigo . '.pdf');
    }

    public function reporteGeneralPDF()
    {
        $faunas = Fauna::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $pdf = PDF::loadView('fauna.reportes.general', compact('faunas'))->setPaper('legal', 'landscape');
        return $pdf->download('reporte_general_fauna.pdf');
    }

public function reportePdf(Request $request)
{
    $userId = Auth::id();

    $query = Fauna::where('user_id', $userId);

    // Si usas soft deletes, así te aseguras que no aparezcan registros eliminados:
    // $query->whereNull('deleted_at'); // Esto es solo si no usas SoftDeletes trait

    // Aplica filtro de institución, si lo quieres igual que index
    if (Auth::check()) {
        $userInstitution = Auth::user()->institucion->nombre ?? null;
        if ($userInstitution) {
            $query->whereRaw('LOWER(institucion_remitente) = ?', [strtolower($userInstitution)]);
        }
    }

    // Aplica los filtros de fecha y código sólo si vienen en la request
    $query = $this->aplicarFiltros($request, $query);

    $faunas = $query->get();

    $pdf = PDF::loadView('fauna.reportepdf', compact('faunas'))
              ->setPaper('legal', 'landscape');

    return $pdf->download('reporte_fauna_filtrado.pdf');
}

public function reporteExcel(Request $request)
{
    $userId = Auth::id();

    $query = Fauna::where('user_id', $userId);

    if (Auth::check()) {
        $userInstitution = Auth::user()->institucion->nombre ?? null;
        if ($userInstitution) {
            $query->whereRaw('LOWER(institucion_remitente) = ?', [strtolower($userInstitution)]);
        }
    }

    $query = $this->aplicarFiltros($request, $query);

    $faunas = $query->get();

    return Excel::download(new \App\Exports\FaunasExport($faunas), 'reporte_fauna_filtrado.xlsx');
}


public function destroy($id)
{
    $fauna = Fauna::findOrFail($id);
    $fauna->delete();

    return redirect()->route('fauna.index')->with('success', 'Registro eliminado correctamente.');
}

public function buscarPorCodigo($codigo)
{
    $fauna = Fauna::where('codigo', $codigo)->first();

    if (!$fauna) {
        return response()->json(['error' => 'Animal no encontrado'], 404);
    }

    return response()->json($fauna);
}

public function duplicar($id)
{
    $registroOriginal = Fauna::findOrFail($id);

    // Excluir campos que no deben copiarse directamente
    $registroClonado = $registroOriginal->replicate([
        'codigo', 'foto', 'created_at', 'updated_at'
    ]);

    // Si tienes una lógica para generar el código automáticamente, este quedará vacío
    // y se genera al guardar (como ya lo tienes)

    return view('fauna.create', [
        'registroDuplicado' => $registroClonado
    ]);
}

private function aplicarFiltros(Request $request, $query)
{
    if ($request->filled('codigo')) {
        $query->where('codigo', 'like', '%' . $request->codigo . '%');
    }

    if ($request->filled('fecha_inicio')) {
        $query->where(function($q) use ($request) {
            $q->whereNull('fecha_recepcion')
              ->orWhereDate('fecha_recepcion', '>=', $request->fecha_inicio);
        });
    }

    if ($request->filled('fecha_fin')) {
        $query->where(function($q) use ($request) {
            $q->whereNull('fecha_recepcion')
              ->orWhereDate('fecha_recepcion', '<=', $request->fecha_fin);
        });
    }

    if ($request->filled('gestion')) {
        $query->where(function($q) use ($request) {
            $q->whereNull('fecha_recepcion')
              ->orWhereYear('fecha_recepcion', $request->gestion);
        });
    }

    return $query;
}


public function generarYGuardarPlantilla()
{
    // Datos de ejemplo
    $fauna = (object) [
        'fecha_recepcion' => '',
        'ciudad' => '',
        'departamento' => '',
        'coordenadas' => '',
        'tipo_elemento' => '',
        'motivo_ingreso' => '',
        'lugar' => '',
        'institucion_remitente' => '',
        'nombre_persona_recibe' => '',
        'foto' => null,
        'codigo' => '',
        'especie' => '',
        'nombre_comun' => '',
        'tipo_animal' => '',
        'edad_aparente' => '',
        'estado_general' => '',
        'sexo' => '',
        'comportamiento' => '',
        'sospecha_enfermedad' => false,
        'descripcion_enfermedad' => '',
        'alteraciones_evidentes' => '',
        'otras_observaciones' => '',
        'tiempo_cautiverio' => '',
        'tipo_alojamiento' => '',
        'contacto_con_animales' => false,
        'descripcion_contacto' => '',
        'padecio_enfermedad' => false,
        'descripcion_padecimiento' => '',
        'tipo_alimentacion' => '',
        'derivacion_ccfs' => false,
        'descripcion_derivacion' => '',
    ];

    // Generar el PDF desde la vista
    $pdf = Pdf::loadView('fauna.plantilla', compact('fauna'))->setPaper('letter', 'landscape');

    // Guardarlo en storage/app/public/plantilla-fauna.pdf
    Storage::disk('public')->put('plantilla-fauna.pdf', $pdf->output());

    return response()->json(['mensaje' => 'PDF generado correctamente.']);
}



}
