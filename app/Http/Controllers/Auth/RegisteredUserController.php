<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Institucion;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar la vista de registro.
     */
    public function create(): View
    {
        $instituciones = Institucion::all(); // Obtiene todas las instituciones
        return view('auth.register', compact('instituciones')); // Pasa a la vista
    }

    /**
     * Manejar la solicitud de registro entrante.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'institucion_id' => ['required', 'exists:instituciones,id'],
        'cargo' => ['required', 'string', 'max:255'],
        'rol' => ['required', 'string', 'in:Medico veterinario zootecnista,Biologo,Administrador,Policia,Otro'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'institucion_id' => $request->institucion_id,
        'cargo' => $request->cargo,
        'rol' => $request->rol,
        'password' => Hash::make($request->password),
    ]);

    // 🔤 Generar código personalizado
    $institucion = $user->institucion;
    $iniciales = strtoupper(implode('', array_map(fn($word) => $word[0], explode(' ', $institucion->nombre))));

    $conteo = User::where('institucion_id', $institucion->id)->count();
    $codigo = $iniciales . '-' . str_pad($conteo, 3, '0', STR_PAD_LEFT);

    $user->codigo = $codigo;
    $user->save();

    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('dashboard');
}
};