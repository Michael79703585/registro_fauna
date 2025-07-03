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

    // Faunas propias del usuario o de su institución
    $faunaPropiaIds = Fauna::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('institucion_id', $user->institucion_id);
        })->pluck('id');

    // Faunas transferidas a su institución
    $faunaTransferidaIds = Transferencia::where('institucion_destino', $user->institucion_id)
                                        ->pluck('fauna_id');

    // Unir ambos conjuntos de fauna
    $faunaIds = $faunaPropiaIds->merge($faunaTransferidaIds)->unique();

    // Cargar faunas disponibles
    $faunas = Fauna::whereIn('id', $faunaIds)
                   ->select('id','codigo','nombre_comun')
                   ->orderBy('codigo')
                   ->get();

    return view('historial.create', compact('faunas','faunaIdSeleccionado'));
}


    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) abort(403, 'Acceso denegado');

        $faunaRegistrada = Fauna::where('user_id',$user->id)->pluck('id');
        $faunaTransferida = Transferencia::where('institucion_destino',$user->institucion_id)
                                         ->pluck('fauna_id');
        $faunaAutorizada = $faunaRegistrada->merge($faunaTransferida)->unique();

        $query = HistorialClinico::whereIn('fauna_id', $faunaAutorizada)
    ->with('fauna.ultimaTransferencia') // <--- aquí
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
        return view('historial.show', compact('historial'));
    }

    public function edit($id)
    {
        $historial = HistorialClinico::with('fauna')->findOrFail($id);
        $this->authorizeInstitution($historial);

        $faunas = Fauna::all();
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
        $pdf = Pdf::loadView('historial.pdf', compact('historial'));
        return $pdf->download("historial_clinico_{$historial->id}.pdf");
    }

    public function reportePdf(Request $request)
    {
        $buscar = $request->input('buscar');
        $user = Auth::user();
        $faunaIds = $this->obtenerFaunaAutorizada($user);

        $historiales = HistorialClinico::with('fauna')
            ->whereIn('fauna_id', $faunaIds)
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('fauna', function ($q) use ($buscar) {
                    $q->where('codigo', 'like', "%$buscar%")
                      ->orWhere('nombre_comun', 'like', "%$buscar%");
                });
            })
            ->orderByDesc('fecha')
            ->get();

        $pdf = Pdf::loadView('historial.reporte-pdf', compact('historiales'))
            ->setPaper('letter', 'landscape')
            ->setOptions([
                'margin-top' => 10,
                'margin-bottom' => 10,
                'margin-left' => 10,
                'margin-right' => 10
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
        $nuevo = $original->replicate();
        $nuevo->fecha = now();
        $nuevo->diagnostico .= ' (copia)';
        $nuevo->save();

        return redirect()->route('historial.edit', $nuevo->id)->with('success', 'Historial duplicado.');
    }

    public function descargarArchivo($id)
    {
        $historial = HistorialClinico::findOrFail($id);
        $ruta = $historial->archivo_laboratorio;

        if (!$ruta || !Storage::disk('public')->exists(str_replace('storage/', '', $ruta))) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->file(storage_path('app/public/' . str_replace('storage/', '', $ruta)));
    }

    public function destroyFauna($id)
    {
        $fauna = Fauna::findOrFail($id);
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

    private function obtenerFaunaAutorizada($user)
    {
        $faunaRegistrada = Fauna::where('user_id', $user->id)->pluck('id');
        $faunaTransferida = Transferencia::where('institucion_destino', $user->institucion_id)->pluck('fauna_id');
        return $faunaRegistrada->merge($faunaTransferida)->unique();
    }
     private function authorizeInstitution(HistorialClinico $historial)
{
    $user = Auth::user();
    $fauna = $historial->fauna;

    if (!$fauna) {
        abort(403, 'No se encontró el animal relacionado.');
    }

    // Obtener la transferencia más reciente (actual dueño institucional)
    $transferenciaActual = Transferencia::where('fauna_id', $fauna->id)
        ->orderByDesc('fecha_transferencia')
        ->first();

    if ($transferenciaActual) {
        // Verificar si el usuario pertenece a la institución destino actual
        if ($user->institucion_id != $transferenciaActual->institucion_destino) {
            abort(403, 'No tienes permiso para acceder a este historial (no eres institución actual).');
        }
    } else {
        // Si no hay transferencias, verificar si el usuario es el propietario original
        if ($fauna->user_id != $user->id) {
            abort(403, 'No tienes permiso para acceder a este historial (no eres el usuario propietario).');
        }
    }
}


}
