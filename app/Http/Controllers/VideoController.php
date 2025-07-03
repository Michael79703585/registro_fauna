<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'video' => 'nullable|file|mimes:mp4,mov,avi|max:51200',
        'video_url' => 'nullable|url',
    ]);

    $path = null;
    if ($request->hasFile('video')) {
        $path = $request->file('video')->store('videos', 'public');
    }

    Video::create([
        'title' => $request->title,
        'video_path' => $path,
        'video_url' => $request->video_url,
    ]);

    return redirect()->back()->with('success', 'Video subido correctamente.');
}

    public function show(string $id)
    {
        $video = Video::findOrFail($id);
        return view('videos.show', compact('video'));
    }

    public function edit(string $id)
    {
        $video = Video::findOrFail($id);
        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, string $id)
    {
        $video = Video::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
            'video_url' => 'nullable|url',
        ]);

        if (!$request->hasFile('video') && !$request->video_url && !$video->video_path && !$video->video_url) {
            return back()->withErrors(['video' => 'Debes mantener o subir un archivo o enlace.']);
        }

        // Reemplazo de video si se sube uno nuevo
        if ($request->hasFile('video')) {
            // Eliminar archivo anterior si existe
            if ($video->video_path) {
                Storage::disk('public')->delete($video->video_path);
            }

            $video->video_path = $request->file('video')->store('videos', 'public');
        }

        $video->title = $request->title;
        $video->video_url = $request->video_url;
        $video->save();

        return redirect()->route('videos.index')->with('success', 'Video actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $video = Video::findOrFail($id);

        // Eliminar archivo del servidor si existe
        if ($video->video_path) {
            Storage::disk('public')->delete($video->video_path);
        }

        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video eliminado correctamente.');
    }

    // Para mostrar videos en la página de inicio (welcome)
    public function home()
    {
        $videos = Video::latest()->get();
        return view('welcome', compact('videos'));
    }
}
