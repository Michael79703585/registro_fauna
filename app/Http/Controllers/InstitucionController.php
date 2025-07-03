<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institucion;
use Illuminate\Support\Facades\Auth;

class InstitucionController extends Controller
{
    public function create()
    {
        return view('instituciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        Institucion::create($validated);

        return redirect()->route('instituciones.create')->with('success', 'Institución registrada correctamente.');
    }

    public function dashboard()
{
    $user = Auth::user();
    $institucion = $user->institucion; // Relación con la tabla 'instituciones'

    return view('recursos.vistas.diseños.app', compact('institucion'));
}

}
