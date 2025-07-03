<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{
    // Método para mostrar el listado de usuarios
    public function index()
    {
        // Traemos todos los usuarios con la relación institucion
        $users = User::with('institucion')->get();

        // Retornamos la vista con los usuarios
        return view('users.index', compact('users'));
    }

   public function show($id)
{
    $usuario = User::findOrFail($id);

    // Cargar registros de fauna de ese usuario
    $registrosFauna = $usuario->faunas()->latest()->get();

    // Obtener todos los historiales clínicos relacionados a las faunas del usuario
    $historiales = \App\Models\HistorialClinico::whereHas('fauna', function($query) use ($usuario) {
        $query->where('user_id', $usuario->id);
    })->latest()->get();

    return view('users.show', compact('usuario', 'registrosFauna', 'historiales'));
}


public function getFauna(User $usuario)
{
    return response()->json($usuario->faunas()->latest()->get());
}

public function getHistoriales(User $usuario)
{
    $historiales = \App\Models\HistorialClinico::with('fauna')
        ->whereIn('fauna_id', $usuario->faunas->pluck('id'))
        ->latest()
        ->get();

    return response()->json($historiales);
}


}
