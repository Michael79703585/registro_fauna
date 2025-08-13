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
use App\Models\Transferencia;
use App\Models\User;
use App\Models\Institucion;


class FaunaController extends Controller
{
  public function index(Request $request)
{
    $user = Auth::user();
    abort_if(!$user, 403, 'Acceso denegado');

    // Obtener IDs de faunas autorizadas para este usuario (según la lógica que tengas)
    $faunaAutorizada = $this->obtenerFaunaAutorizada($user);

    // Iniciamos query sobre Fauna, filtrando por IDs autorizados
    $query = Fauna::whereIn('id', $faunaAutorizada);

    // Aplicar filtros si existen
    if ($request->filled('codigo')) {
        $query->where('codigo', 'like', '%' . $request->codigo . '%');
    }

    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_recepcion', '>=', $request->fecha_inicio);
    }

    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_recepcion', '<=', $request->fecha_fin);
    }

    if ($request->filled('gestion')) {
        $query->where('gestion', $request->gestion);
    }

    // Cargar relación con usuario para mostrar datos relacionados en la vista
    $faunas = $query->with('user.institucion')->orderBy('created_at', 'desc')->paginate(15)->appends($request->except('page'));

    // Para llenar filtros en la vista
    $gestiones = Fauna::select('gestion')->distinct()->pluck('gestion');

    
    
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
        'foto' => 'nullable|image|max:10048',
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

         $this->authorizeInstitution($fauna);
        return view('fauna.edit', compact('fauna'));
    }

   public function update(Request $request, $id)
{
    $fauna = Fauna::findOrFail($id);

 // 🔒 Restringe acceso a institución receptora
    $this->authorizeInstitution($fauna);

    $validated = $request->validate([
        'institucion_destino' => 'nullable|exists:instituciones,id',
        'user_destino_id' => 'nullable|exists:users,id',
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
        'foto' => 'nullable|image|max:10048',
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

    // Guardar los datos generales
    $fauna->update($validated);

    // Guardar la transferencia correctamente
    if ($request->filled('institucion_destino')) {
        $institucionDestinoNombre = \App\Models\Institucion::find($request->institucion_destino)?->nombre;
        $fauna->institucion_destino = $institucionDestinoNombre;
        $fauna->transferido = true;
        $fauna->save();
    }

    return redirect()->route('fauna.index')->with('success', 'Registro actualizado correctamente.');
}


    public function exportPDF($id)
    {
        $fauna = Fauna::findOrFail($id);
        $pdf = PDF::loadView('fauna.pdf', compact('fauna'))->setPaper('letter', 'landscape');
        return $pdf->download('ficha_fauna_' . $fauna->codigo . '.pdf');
    }



public function reportePDF(Request $request)
{
    $user = Auth::user();
    $faunaIds = $this->obtenerFaunaAutorizada($user);
    $faunas = Fauna::whereIn('id', $faunaIds)->get();

    if ($faunas->isEmpty()) {
        return back()->with('error', 'No hay datos para generar el reporte.');
    }

    // Verifica que sí trae datos
    // dd($faunas);

    $pdf = PDF::loadView('fauna.reportepdf', compact('faunas'))
              ->setPaper('legal', 'landscape');

    return $pdf->download('reporte_fauna_filtrado.pdf');
}




public function reporteExcel(Request $request)
{
    $user = Auth::user();

    // Obtener fauna autorizada (IDs)
    $faunaIds = $this->obtenerFaunaAutorizada($user);

    $faunas = Fauna::whereIn('id', $faunaIds)->get();

    if ($faunas->isEmpty()) {
        return back()->with('error', 'No hay datos para exportar.');
    }

    return Excel::download(new \App\Exports\FaunasExport($faunas), 'reporte_fauna_filtrado.xlsx');
}

public function destroy($id)
{
    $fauna = Fauna::findOrFail($id);
     $this->authorizeInstitution($fauna);
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

private function authorizeInstitution(Fauna $fauna)
{
    $user = Auth::user();

    // Buscar la última transferencia de la fauna
    $transferenciaActual = Transferencia::where('fauna_id', $fauna->id)
        ->orderByDesc('fecha_transferencia')
        ->first();

    if ($transferenciaActual) {
        // Solo permite acción si el usuario pertenece a la institución destino de la última transferencia
        if ($transferenciaActual->institucion_destino != $user->institucion_id) {
            abort(403, 'No tienes permiso para modificar o eliminar esta fauna.');
        }
    } else {
        // Si no hay transferencias, solo permite acción si pertenece a la institución del usuario que creó la fauna
        if ($fauna->user->institucion_id != $user->institucion_id) {
            abort(403, 'No tienes permiso para modificar o eliminar esta fauna.');
        }
    }
}



    private function authorizeView(Fauna $fauna): void
    {
        $user = Auth::user();
        $fauna = $fauna->fauna;

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




