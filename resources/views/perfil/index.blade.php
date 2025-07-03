@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-blue-800 mb-6">👤 Perfil de {{ $user->name }}</h2>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div>
                <dt class="font-semibold">Nombre</dt>
                <dd>{{ $user->name }}</dd>
            </div>

            <div>
                <dt class="font-semibold">Correo electrónico</dt>
                <dd>{{ $user->email }}</dd>
            </div>

            @if(!empty($user->telefono))
            <div>
                <dt class="font-semibold">Teléfono</dt>
                <dd>{{ $user->telefono }}</dd>
            </div>
            @endif

            @if(!empty($user->direccion))
            <div>
                <dt class="font-semibold">Dirección</dt>
                <dd>{{ $user->direccion }}</dd>
            </div>
            @endif

            <div>
                <dt class="font-semibold">Fecha de registro</dt>
                <dd>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'No disponible' }}</dd>
            </div>

            <div>
                <dt class="font-semibold">Institución</dt>
                <dd>{{ $user->institucion->nombre ?? 'No asignada' }}</dd>
            </div>
        </dl>

        <div class="mt-8 text-right">
            <a href="{{ route('perfil.editar') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded inline-block">
                ✏️ Editar Perfil
            </a>
        </div>
    </div>
@endsection
