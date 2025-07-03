@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-8 bg-white rounded-2xl shadow-xl space-y-10 mt-10">

    {{-- Encabezado --}}
    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3 border-b border-gray-300 pb-4">
        📄 Detalle de la Parte / Derivado
    </h1>

    {{-- Información --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-800 text-base">

        @php
            $fields = [
                '🆔 Código' => $parte->codigo,
                '📋 Tipo de Registro' => ucfirst(str_replace('_', ' ', $parte->tipo_registro)),
                '📅 Fecha de Recepción' => \Carbon\Carbon::parse($parte->fecha_recepcion)->format('d/m/Y'),
                '🏙️ Ciudad' => $parte->ciudad,
                '🗺️ Departamento' => $parte->departamento,
                '📍 Coordenadas' => $parte->coordenadas,
                '🏛️ Institución' => $parte->institucion_remitente,
                '🙋 Persona que Recibe' => $parte->nombre_persona_recibe,
                '📦 Tipo de Elemento' => $parte->tipo_elemento,
                '📖 Motivo de Ingreso' => ucfirst($parte->motivo_ingreso),
                '🔢 Cantidad' => $parte->cantidad,
                '🐾 Tipo de Animal' => $parte->tipo_animal,
                '🌿 Especie' => $parte->especie,
                '📛 Nombre Común' => $parte->nombre_comun,
                '📅 Fecha de Disposición' => \Carbon\Carbon::parse($parte->fecha)->format('d/m/Y'),
                '🏁 Disposición Final' => $parte->disposicion_final,
            ];
        @endphp

        @foreach($fields as $label => $value)
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-sm font-semibold text-gray-500">{{ $label }}</p>
                <p class="mt-1 text-gray-900 leading-relaxed whitespace-pre-line">
                    @if($label === '🐾 Tipo de Animal')
                        @switch($value)
                            @case('Mamífero') 🐾 @break
                            @case('Ave') 🐦 @break
                            @case('Reptil') 🐍 @break
                            @case('Anfibio') 🐸 @break
                            @default 🦎
                        @endswitch
                        {{ ucfirst($value) }}
                    @elseif($label === '🌿 Especie')
                        <span class="italic">{{ $value ?: '—' }}</span>
                    @else
                        {{ $value ?: '—' }}
                    @endif
                </p>
            </div>
        @endforeach

        {{-- Observaciones --}}
        <div class="md:col-span-2 bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <p class="text-sm font-semibold text-gray-500 mb-1">📝 Observaciones</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $parte->observaciones ?: '—' }}</p>
        </div>

        {{-- Fotografía --}}
        <div class="md:col-span-2 text-center mt-6">
            <p class="text-xl font-semibold text-gray-700 mb-4">📸 Fotografía</p>
            @if ($parte->foto && file_exists(public_path('storage/partes_fotos/' . $parte->foto)))
                <img src="{{ asset('storage/partes_fotos/' . $parte->foto) }}" alt="Foto"
                     class="mx-auto max-w-md rounded-2xl border border-gray-300 shadow-lg transition-transform hover:scale-105 duration-300">
            @else
                <p class="italic text-gray-400">Foto no disponible</p>
            @endif
        </div>

    </div>

    {{-- Botones --}}
    <div class="pt-10 flex flex-wrap justify-center md:justify-start gap-6">
        <a href="{{ route('partes.edit', $parte->id) }}"
           class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
            ✏️ Editar
        </a>

        <a href="{{ route('partes.index') }}"
           class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium px-6 py-3 rounded-xl shadow transition duration-300">
            🔙 Volver
        </a>

        <a href="{{ route('partes.pdf', $parte->id) }}"
           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
            📄 Descargar PDF
        </a>
    </div>

</div>
@endsection
