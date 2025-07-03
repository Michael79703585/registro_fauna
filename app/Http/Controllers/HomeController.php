<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Video;

class HomeController extends Controller
{
    /**
     * Muestra la página principal con publicaciones y videos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener publicaciones y videos ordenados por fecha más reciente
        $publicaciones = Publication::latest()->get();
        $videos = Video::latest()->get();

        // Retornar la vista welcome con las variables correctas
        return view('welcome', compact('publicaciones', 'videos'));
    }
}

