@extends('layouts.app')

@section('title', 'Detalle de Liberación')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-lg space-y-8">

    {{-- Encabezado --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            🦅 Detalle de Liberación
        </h2>
    </div>

    {{-- Información de la liberación --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @php
            $campos = [
                '🆔 Código' => $liberacion->codigo,
                '📅 Fecha' => \Carbon\Carbon::parse($liberacion->fecha)->format('d/m/Y'),
                '📍 Lugar de Liberación' => $liberacion->lugar_liberacion,
                '🏛️ Departamento' => $liberacion->departamento,
                '🏙️ Municipio' => $liberacion->municipio,
                '🧭 Coordenadas' => $liberacion->coordenadas ?? '—',
                '🐾 Tipo de Animal' => $liberacion->tipo_animal,
                '🌿 Especie' => $liberacion->especie,
                '🔤 Nombre Común' => $liberacion->nombre_comun ?? '—',
                '🙋 Responsable' => $liberacion->responsable,
                '🏢 Institución' => $liberacion->institucion,
            ];
        @endphp

        @foreach ($campos as $label => $valor)
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-600 font-semibold">{{ $label }}</p>
                <p class="text-gray-800 mt-1 {{ Str::contains($label, 'Especie') ? 'italic' : '' }}">
                    {{ $valor }}
                </p>
            </div>
        @endforeach

        {{-- Observaciones --}}
        <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-200 shadow-sm">
            <p class="text-sm text-gray-600 font-semibold">📝 Observaciones</p>
            <p class="text-gray-800 mt-1 whitespace-pre-line">{{ $liberacion->observaciones ?? '—' }}</p>
        </div>
    </div>

    {{-- Fotografía --}}
    <div class="text-center mt-8">
        <p class="text-lg font-semibold text-gray-700 mb-2">📸 Fotografía</p>
        @if ($liberacion->foto && file_exists(storage_path('app/public/' . $liberacion->foto)))
            <img src="{{ asset('storage/' . $liberacion->foto) }}" alt="Fotografía de la liberación"
                 class="mx-auto max-w-xs rounded-lg border shadow-md transition-transform hover:scale-105 duration-200">
        @else
            <p class="text-gray-500 italic">No se ha subido ninguna fotografía.</p>
        @endif
    </div>

    {{-- Botones --}}
    <div class="pt-8 flex flex-wrap gap-4 justify-center">
        <a href="{{ route('liberaciones.exportPdfIndividual', $liberacion->id) }}"
           class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-lg shadow transition">
           📄 Exportar PDF
        </a>

        <a href="{{ route('liberaciones.index') }}"
           class="inline-flex items-center px-4 py-2 bg-white text-blue-600 border border-blue-600 rounded-lg shadow-sm hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver al listado
        </a>
    </div>

</div>
@endsection
