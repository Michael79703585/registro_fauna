@extends('layouts.app')

@section('title', 'Detalle de Transferencia')

@section('content')
<div class="max-w-6xl mx-auto p-8 bg-white rounded-2xl shadow-xl space-y-10 mt-10">

    {{-- Encabezado --}}
    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3 border-b border-gray-300 pb-4">
        📋 Detalle de Transferencia de Fauna
    </h1>

    {{-- Información --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-800 text-base">

        @php
    $fields = [
        '🆔 Código' => $transferencia->fauna->codigo ?? 'N/A',
        '🐾 Tipo Animal' => $transferencia->fauna->tipo_animal ?? 'N/A',
        '🌿 Especie' => $transferencia->fauna->especie ?? 'N/A',
        '📅 Fecha de Transferencia' => $transferencia->fecha_transferencia_formateada ?? 'N/A',
        '🏛️ Institución Origen' => $transferencia->institucionOrigen->nombre ?? 'N/A',
        '🏢 Institución Destino' => $transferencia->institucionDestino->nombre ?? 'N/A',
        '📖 Motivo' => $transferencia->motivo ?? 'N/A',
        '📝 Observaciones' => $transferencia->observaciones ?? 'N/A',
        '⚙️ Estado' => $transferencia->estado ?? 'N/A',
    ];
@endphp

        @foreach($fields as $label => $value)
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-sm font-semibold text-gray-500">{{ $label }}</p>
                <p class="mt-1 text-gray-900 leading-relaxed whitespace-pre-line">
                    @if($label === '🐾 Tipo Animal')
                        @switch($value)
                            @case('Mamífero') 🐾 @break
                            @case('Ave') 🐦 @break
                            @case('Reptil') 🐍 @break
                            @case('Anfibio') 🐸 @break
                            @default 🦎
                        @endswitch
                        {{ ucfirst($value) !== 'N/a' ? ucfirst($value) : '—' }}
                    @elseif($label === '🌿 Especie')
                        <span class="italic">{{ $value !== 'N/A' ? $value : '—' }}</span>
                    @elseif($label === '⚙️ Estado')
                        @php
                            $estadoColor = match(strtolower($value)) {
                                'pendiente' => 'text-yellow-600 font-semibold',
                                'aceptado' => 'text-green-600 font-semibold',
                                'rechazado' => 'text-red-600 font-semibold',
                                default => 'text-gray-600'
                            };
                        @endphp
                        <span class="{{ $estadoColor }}">{{ ucfirst($value) !== 'N/a' ? ucfirst($value) : '—' }}</span>
                    @else
                        {{ $value !== 'N/A' ? $value : '—' }}
                    @endif
                </p>
            </div>
        @endforeach

    </div>

    {{-- Botones --}}
    <div class="pt-10 flex flex-wrap justify-center md:justify-start gap-6">
        <a href="{{ route('transferencias.index') }}"
           class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium px-6 py-3 rounded-xl shadow transition duration-300">
            🔙 Volver
        </a>

        @if (Auth::user()->institucion_id === $transferencia->institucion_origen)
            <a href="{{ route('transferencias.pdf', $transferencia->id) }}"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
                📄 Descargar PDF
            </a>
        @endif
    </div>

</div>
@endsection
