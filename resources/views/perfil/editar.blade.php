@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-10 rounded-2xl shadow-xl border border-blue-100">
    <h2 class="text-3xl font-bold text-blue-800 mb-8 uppercase tracking-wide">
        ✏️ Editar Perfil
    </h2>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded shadow-sm">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="name" id="name"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico</label>
            <input type="email" name="email" id="email"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Teléfono -->
        <div>
            <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="telefono" id="telefono"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="{{ old('telefono', $user->telefono) }}">
        </div>

        <!-- Dirección -->
        <div>
            <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
            <input type="text" name="direccion" id="direccion"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                   value="{{ old('direccion', $user->direccion) }}">
        </div>

        <!-- Institución -->
        <div>
            <label for="institucion_id" class="block text-sm font-semibold text-gray-700 mb-1">Institución</label>
            <select name="institucion_id" id="institucion_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="">-- Seleccionar Institución --</option>
                @foreach($instituciones as $inst)
                    <option value="{{ $inst->id }}" {{ old('institucion_id', $user->institucion_id) == $inst->id ? 'selected' : '' }}>
                        {{ $inst->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nueva Contraseña -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Nueva Contraseña</label>
            <input type="password" name="password" id="password"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <!-- Botón -->
        <div class="pt-4 text-right">
            <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-bold px-6 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                💾 Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
