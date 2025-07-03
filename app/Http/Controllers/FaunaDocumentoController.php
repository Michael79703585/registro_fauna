<?php

namespace App\Http\Controllers;

use App\Models\Fauna;
use App\Models\FaunaDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FaunaDocumentoController extends Controller
{
    // Mostrar todos los documentos de una fauna
    public function index(Fauna $fauna)
    {
        $documentos = $fauna->documentos;
        return view('fauna.documentos.index', compact('fauna', 'documentos'));
    }

    // Mostrar formulario de carga
    public function create(Fauna $fauna)
    {
        return view('fauna.documentos.create', compact('fauna'));
    }

    // Guardar el archivo subido
    // Guardar el archivo subido
public function store(Request $request, Fauna $fauna)
{
    $this->authorize('create', $fauna);

    $request->validate([
        'archivo' => 'required|file|max:10240', // máx 10MB
        'tipo_documento' => 'nullable|string|max:255',
    ]);

    $archivo = $request->file('archivo');
    $nombreOriginal = $archivo->getClientOriginalName();
    $nombreUnico = Str::uuid() . '_' . $nombreOriginal;

    // Guardar SIN prefijo 'public/'
    $ruta = $archivo->storeAs("faunas/{$fauna->id}", $nombreUnico, 'public');

    $fauna->documentos()->create([
        'nombre_archivo' => $nombreOriginal,
        'ruta_archivo' => $ruta, // Aquí guardamos solo la ruta relativa sin 'public/'
        'tipo_documento' => $request->input('tipo_documento'),
    ]);

    return redirect()
        ->route('fauna.documentos.index', $fauna->id)
        ->with('success', 'Documento cargado correctamente.');
}

    // Descargar documento
    public function download($documentoId)
    {
        $documento = FaunaDocumento::findOrFail($documentoId);

        $this->authorize('view', $documento->fauna);

        if (!Storage::exists($documento->ruta_archivo)) {
            return redirect()->back()->with('error', 'El archivo no existe en el servidor.');
        }

        return Storage::download($documento->ruta_archivo, $documento->nombre_archivo);
    }

    // Eliminar documento (verifica que el documento pertenezca a la fauna)
    public function destroy(Fauna $fauna, $documentoId)
{
    $this->authorize('delete', $fauna);

    $documento = FaunaDocumento::where('id', $documentoId)
                               ->where('fauna_id', $fauna->id)
                               ->firstOrFail();

    if (Storage::exists($documento->ruta_archivo)) {
        Storage::delete($documento->ruta_archivo);
    }

    $documento->delete();

    return back()->with('success', 'Documento eliminado correctamente.');
}
};