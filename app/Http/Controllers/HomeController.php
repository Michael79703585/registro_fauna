<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;

class HomeController extends Controller
{
    /**
     * Muestra la página principal con publicaciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener publicaciones ordenadas por fecha más reciente
        $publicaciones = Publication::latest()->get();

        // Retornar la vista welcome solo con publicaciones
        return view('welcome', compact('publicaciones'));
    }
}
