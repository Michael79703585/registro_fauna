<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Institucion;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar perfil
    public function show()
    {
        $user = Auth::user();

        if (!$user || !($user instanceof User)) {
            return redirect()->route('login');
        }

        $user->load('institucion');

        return view('perfil.show', compact('user'));
    }

    // Mostrar formulario para editar perfil
    public function edit()
    {
        $user = Auth::user();
        $instituciones = Institucion::all();

        return view('perfil.editar', compact('user', 'instituciones'));
    }

    // Guardar los cambios del perfil
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || !($user instanceof User)) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'institucion_id' => 'nullable|exists:instituciones,id',
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Asignar los valores actualizados
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->telefono = $validated['telefono'] ?? null;
        $user->direccion = $validated['direccion'] ?? null;
        $user->institucion_id = $validated['institucion_id'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado con éxito.');
    }
}
