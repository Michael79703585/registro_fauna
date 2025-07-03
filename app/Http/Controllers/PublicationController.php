<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class PublicationController extends Controller
{
    public function index()
    {
        $publicaciones = Publication::latest()->get();
        $videos = Video::latest()->get();

        return view('welcome', compact('publicaciones', 'videos'));
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
            'files.*' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:90240', // hasta 90MB por archivo
        ]);

        $paths = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('publicaciones', 'public');
            }
        }

        Publication::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => json_encode($paths),
        ]);

        return redirect()->route('publication.index')->with('success', '¡Publicación subida exitosamente!');
    }

    public function edit($id)
    {
        $publicacion = Publication::findOrFail($id);
        $publicacion->image_path = json_decode($publicacion->image_path, true);
        return view('publicaciones.edit', compact('publicacion'));
    }

    public function update(Request $request, $id)
    {
        $publicacion = Publication::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:90240',
        ]);

        $publicacion->title = $request->title;
        $publicacion->description = $request->description;

        if ($request->hasFile('files')) {
            // Eliminar archivos antiguos
            $oldFiles = json_decode($publicacion->image_path, true);
            if (is_array($oldFiles)) {
                foreach ($oldFiles as $oldFile) {
                    Storage::disk('public')->delete($oldFile);
                }
            }

            $paths = [];
            foreach ($request->file('files') as $file) {
                $paths[] = $file->store('publicaciones', 'public');
            }

            $publicacion->image_path = json_encode($paths);
        }

        $publicacion->save();

        return redirect()->route('publication.index')->with('success', 'Publicación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $publicacion = Publication::findOrFail($id);

        $files = json_decode($publicacion->image_path, true);
        if (is_array($files)) {
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $publicacion->delete();

        return redirect()->route('publication.index')->with('success', 'Publicación eliminada correctamente.');
    }

    public function show(Publication $publication)
    {
        return view('publicaciones.show', compact('publication'));
    }
}
