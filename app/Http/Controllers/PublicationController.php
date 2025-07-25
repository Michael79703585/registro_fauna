<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
  public function index()
{
    $publicaciones = Publication::latest()->get(); // o tu lógica
    return view('publicaciones.index', compact('publicaciones'));
}



    public function create()
    {
        return view('publicaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:90240',
        ]);

        $paths = [];
        foreach ($request->file('files', []) as $file) {
            $paths[] = $file->store('publicaciones', 'public');
        }

        Publication::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => json_encode($paths),
        ]);

        return redirect()->route('publicaciones.index')->with('success', '¡Publicación subida exitosamente!');
    }

    public function show(Publication $publication)
    {
        $publication->image_path = json_decode($publication->image_path, true);
        return view('publicaciones.show', compact('publication'));
    }

    public function edit($id)
    {
        $publication = Publication::findOrFail($id);
        $publication->image_path = json_decode($publication->image_path, true);
        return view('publicaciones.edit', compact('publication'));
    }

    public function update(Request $request, $id)
    {
        $publication = Publication::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:90240',
        ]);

        $publication->title = $request->title;
        $publication->description = $request->description;

        $existingFiles = json_decode($publication->image_path, true) ?? [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $existingFiles[] = $file->store('publicaciones', 'public');
            }
        }

        $publication->image_path = json_encode($existingFiles);
        $publication->save();

        return redirect()->route('publicaciones.index')->with('success', 'Publicación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $publication = Publication::findOrFail($id);

        $files = json_decode($publication->image_path, true) ?? [];
        foreach ($files as $file) {
            Storage::disk('public')->delete($file);
        }

        $publication->delete();

        return redirect()->route('publicaciones.index')->with('success', 'Publicación eliminada correctamente.');
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:90120',
        ]);

        $publication = Publication::findOrFail($id);

        $oldFiles = json_decode($publication->image_path, true);
        if (is_array($oldFiles)) {
            foreach ($oldFiles as $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        $path = $request->file('image')->store('publicaciones', 'public');

        $publication->image_path = json_encode([$path]);
        $publication->save();

        return redirect()->route('publicaciones.index')->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroyFile($publicationId, $index)
{
    $publication = Publication::findOrFail($publicationId);

    $files = json_decode($publication->image_path, true) ?? [];

    if (isset($files[$index])) {
        // Borra el archivo físico
        Storage::disk('public')->delete($files[$index]);

        // Elimina el archivo del array
        array_splice($files, $index, 1);

        // Actualiza la publicación
        $publication->image_path = json_encode($files);
        $publication->save();

        return redirect()->back()->with('success', 'Archivo eliminado correctamente.');
    }

    return redirect()->back()->with('error', 'Archivo no encontrado.');
}

    
}
