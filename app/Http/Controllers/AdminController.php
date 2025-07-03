<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fauna;
use App\Models\HistorialClinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
{
    if (!Auth::check() || Auth::user()->email !== 'michaelleon2109@gmail.com') {
        abort(403, 'Acceso no autorizado');
    }

    // Filtros desde el request
    $usuario = $request->input('usuario');
    $especie = $request->input('especie');
    $diagnostico = $request->input('diagnostico');

    // Usuarios con filtro y paginación
    $usuarios = User::when($usuario, fn($query) => 
                $query->where('name', 'like', "%$usuario%")
                      ->orWhere('email', 'like', "%$usuario%"))
                ->paginate(10)
                ->appends($request->except('page'));

    // Fauna con filtros y paginación
    $registrosFauna = Fauna::with('user')
        ->when($usuario, fn($query) => $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$usuario%")))
        ->when($especie, fn($query) => $query->where('especie', 'like', "%$especie%"))
        ->latest()
        ->paginate(10)
        ->appends($request->except('page'));

    // Historiales con filtros y paginación
    $historiales = HistorialClinico::with('fauna')
        ->when($diagnostico, fn($query) => $query->where('diagnostico', 'like', "%$diagnostico%"))
        ->when($especie, fn($query) => $query->whereHas('fauna', fn($q) => $q->where('especie', 'like', "%$especie%")))
        ->latest()
        ->paginate(10)
        ->appends($request->except('page'));

    return view('admin.dashboard', compact('usuarios', 'registrosFauna', 'historiales'));
}


    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->email !== 'michaelleon2109@gmail.com') {
            abort(403, 'Acceso no autorizado');
        }

        $usuario = User::findOrFail($id);

        if ($usuario->email === 'michaelleon2109@gmail.com') {
            return redirect()->back()->with('error', 'No puedes eliminar al administrador principal.');
        }

        $usuario->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }
}
