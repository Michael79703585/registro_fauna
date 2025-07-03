@extends('layouts.app')

@section('title', 'Detalle Evento')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6">📄 Detalle del Evento #{{ $evento->id }}</h2>

    @php
        $edades = ['Neonato', 'Juvenil', 'Adulto', 'Geronte'];
        $tipo = strtolower(optional($evento->tipoEvento)->nombre);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <p><strong>Tipo de Evento:</strong> {{ optional($evento->tipoEvento)->nombre ?? '-' }}</p>
            <p><strong>Fecha:</strong> {{ $evento->fecha ? $evento->fecha->format('d/m/Y') : '-' }}</p>
            <p><strong>Especie:</strong> <span class="italic">{{ $evento->especie ?? '-' }}</span></p>
            <p><strong>Nombre común:</strong> {{ $evento->nombre_comun ?? '-' }}</p>
            <p><strong>Sexo:</strong> {{ $evento->sexo ?? '-' }}</p>

            @if($tipo === 'fuga')
                <p><strong>Código Animal:</strong> {{ $evento->codigo_animal ?? '-' }}</p>
            @else
                <p><strong>Código Animal:</strong> {{ $evento->codigo ?? '-' }}</p>
            @endif

            <p><strong>Institución:</strong> {{ optional($evento->institucion)->nombre ?? '-' }}</p>
        </div>

        <div>
            @if($evento->foto)
                <img src="{{ asset('storage/' . $evento->foto) }}" alt="Foto evento" class="w-full rounded shadow mb-4" />
            @else
                <p class="italic text-gray-600">Sin foto disponible</p>
            @endif
        </div>
    </div>

    {{-- Detalles específicos según tipo --}}
    @if($tipo === 'nacimiento')
        <section class="mt-6 p-4 bg-yellow-50 rounded">
            <h3 class="font-semibold text-lg mb-2">Detalles Nacimiento</h3>
            <p><strong>Señas particulares:</strong> {{ $evento->senas_particulares ?? '-' }}</p>
            <p><strong>Código de padres:</strong> {{ $evento->codigo_padres ?? '-' }}</p>
        </section>
    @elseif($tipo === 'deceso')
        <section class="mt-6 p-4 bg-red-50 rounded">
            <h3 class="font-semibold text-lg mb-2">Detalles Deceso</h3>
            <p><strong>Causas del deceso:</strong> {{ $evento->causas_deceso ?? '-' }}</p>
            <p><strong>Tratamientos realizados:</strong> {{ $evento->tratamientos_realizados ?? '-' }}</p>
        </section>
    @elseif($tipo === 'fuga')
        <section class="mt-6 p-4 bg-blue-50 rounded">
            <h3 class="font-semibold text-lg mb-2">Detalles Fuga</h3>
            <p><strong>Descripción de la fuga:</strong> {{ $evento->descripcion_fuga ?? '-' }}</p>
        </section>
    @endif

    <section class="mt-6 p-4 bg-gray-50 rounded">
        <h3 class="font-semibold text-lg mb-2">Observaciones</h3>
        <p>{{ $evento->observaciones ?? '-' }}</p>
    </section>

    {{-- Botones de acción mejorados --}}
    <div class="mt-6 flex flex-wrap gap-4 justify-end">
        <a href="{{ route('eventos.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-500 text-gray-700 hover:bg-gray-200 transition duration-150 ease-in-out shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver
        </a>

        <a href="{{ route('eventos.edit', $evento->id) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-yellow-500 text-white hover:bg-yellow-600 transition duration-150 ease-in-out shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2m-1 0v14m8-7H5"/>
            </svg>
            Editar
        </a>

        <a href="{{ route('eventos.exportar_pdf_individual', $evento->id) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition duration-150 ease-in-out shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Imprimir PDF
        </a>
    </div>
</div>
@endsection
