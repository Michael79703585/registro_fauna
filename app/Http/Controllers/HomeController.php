<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $publicaciones = Publication::latest()->get();

        $publicacionesJson = $publicaciones->map(function ($p) {
            $archivos = is_array($p->image_path) ? $p->image_path : json_decode($p->image_path, true);
            return [
                'id' => $p->id,
                'title' => $p->title,
                'archivos' => $archivos ?: [],
            ];
        });

        return view('welcome', [
            'publicaciones' => $publicaciones,
            'publicacionesJson' => $publicacionesJson,
        ]);
    }

    // Ruta para actualizar imagen
    public function actualizarImagen(Request $request, $id)
    {
        $request->validate([
    'image' => 'required|file|mimes:jpeg,png,jpg,gif,bmp,pdf|max:90048',
]);


        $publicacion = Publication::findOrFail($id);

        // Guardar imagen en storage/app/public
        $path = $request->file('image')->store('publicaciones', 'public');

        // Obtener solo el nombre relativo (ej: publicaciones/archivo.jpg)
        $nombreArchivo = str_replace('public/', '', $path);

        // Decodificar array actual de imágenes o crear uno vacío
        $archivos = is_array($publicacion->image_path) ? $publicacion->image_path : json_decode($publicacion->image_path, true);
        $archivos = $archivos ?: [];

        // Aquí reemplazamos la primera imagen (o ajusta según lógica que necesites)
        $index = $request->input('image_index', 0); // Por defecto 0

$index = $request->input('image_index', 0); // Por defecto 0

if (isset($archivos[$index])) {
    $archivos[$index] = $nombreArchivo;
} else {
    $archivos[] = $nombreArchivo;
}


        // Guardar de nuevo como JSON
        $publicacion->image_path = json_encode($archivos);
        $publicacion->save();

        // Devolver URL completa para mostrar
        $url = asset('storage/' . $nombreArchivo);

        return response()->json(['url' => $url]);
    }
}
