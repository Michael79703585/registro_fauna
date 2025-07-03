@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="max-w-4xl mx-auto bg-gradient-to-r from-blue-50 to-white p-10 rounded-xl shadow-lg border border-blue-200">
    <h2 style="font-size: 20px; font-weight: 800; text-transform: uppercase; color: #1e40af; margin-bottom: 2rem; letter-spacing: 0.1em; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
    👤 INFORMACIÓN DEL USUARIO
</h2>

    <dl class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-800">
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <dt class="font-semibold text-sm text-blue-600 uppercase tracking-wide mb-1">Nombre</dt>
            <dd class="text-lg font-medium">{{ $user->name }}</dd>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <dt class="font-semibold text-sm text-blue-600 uppercase tracking-wide mb-1">Correo electrónico</dt>
            <dd class="text-lg font-medium break-all">{{ $user->email }}</dd>
        </div>

        @if(!empty($user->telefono))
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <dt class="font-semibold text-sm text-blue-600 uppercase tracking-wide mb-1">📞 Teléfono</dt>
            <dd class="text-lg font-medium">{{ $user->telefono }}</dd>
        </div>
        @endif

        @if(!empty($user->direccion))
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <dt class="font-semibold text-sm text-blue-600 uppercase tracking-wide mb-1">🏠 Dirección</dt>
            <dd class="text-lg font-medium">{{ $user->direccion }}</dd>
        </div>
        @endif

        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <dt class="font-semibold text-sm text-blue-600 uppercase tracking-wide mb-1">📅 Fecha de registro</dt>
            <dd class="text-lg font-medium">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'No disponible' }}</dd>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <dt class="font-semibold text-sm text-blue-600 uppercase tracking-wide mb-1">🏢 Institución</dt>
            <dd class="text-lg font-medium">{{ $user->institucion->nombre ?? 'No asignada' }}</dd>
        </div>
    </dl>

  <div class="mt-10 text-right">
    <a href="{{ route('perfil.edit') }}" 
       style="background-color: #1e40af; /* azul intenso */
              color: white; 
              font-weight: 900; 
              font-size: 1.1rem;  /* tamaño más pequeño */
              padding: 0.5rem 1.5rem;  /* menos padding */
              border-radius: 0.75rem; 
              box-shadow: 0 6px 12px rgba(30, 64, 175, 0.4);
              border: 2px solid #2563eb;  /* borde más delgado */
              transition: all 0.3s ease;
              display: inline-block;"
       onmouseover="this.style.backgroundColor='#1e3a8a'; this.style.borderColor='#60a5fa'; this.style.transform='scale(1.05)';"
       onmouseout="this.style.backgroundColor='#1e40af'; this.style.borderColor='#2563eb'; this.style.transform='scale(1)';"
    >
       ✏️ Editar Perfil
    </a>
</div>

</div>
@endsection
