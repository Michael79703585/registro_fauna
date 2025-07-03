@extends('layouts.app')

@section('title', 'Editar Evento')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">✏️ Editar Evento #{{ $evento->id }}</h2>

    <form method="POST" action="{{ route('eventos.update', $evento->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tipo de evento --}}
        <div class="mb-4">
            <label for="tipo_evento_id" class="block font-medium">Tipo de Evento</label>
            <select name="tipos_evento_id" id="tipo_evento_id" class="w-full border rounded px-3 py-2" required>
                @foreach($tipoEvento as $tipo)
                    <option value="{{ $tipo->id }}" {{ $tipo->id == old('tipo_evento_id', $evento->tipo_evento_id) ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('tipo_evento_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fecha --}}
        <div class="mb-4">
            <label for="fecha" class="block font-medium">Fecha</label>
            <input type="date" id="fecha" name="fecha" class="w-full border rounded px-3 py-2" 
                value="{{ old('fecha', $evento->fecha?->format('Y-m-d')) }}" required>
            @error('fecha')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Especie --}}
        <div class="mb-4">
            <label for="especie" class="block font-medium">Especie</label>
            <input type="text" id="especie" name="especie" class="w-full border rounded px-3 py-2" 
                value="{{ old('especie', $evento->especie) }}" required>
            @error('especie')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nombre común --}}
        <div class="mb-4">
            <label for="nombre_comun" class="block font-medium">Nombre común</label>
            <input type="text" id="nombre_comun" name="nombre_comun" class="w-full border rounded px-3 py-2" 
                value="{{ old('nombre_comun', $evento->nombre_comun) }}">
            @error('nombre_comun')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Campos específicos para Nacimiento --}}
        @if(optional($evento->tipoEvento)->nombre === 'Nacimiento')
            {{-- Sexo --}}
            <div class="mb-4">
                <label for="sexo" class="block font-medium">Sexo</label>
                <select name="sexo" id="sexo" class="w-full border rounded px-3 py-2">
                    <option value="" {{ old('sexo', $evento->sexo) === null ? 'selected' : '' }}>Seleccione</option>
                    <option value="Macho" {{ old('sexo', $evento->sexo) === 'Macho' ? 'selected' : '' }}>Macho</option>
                    <option value="Hembra" {{ old('sexo', $evento->sexo) === 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    <option value="Desconocido" {{ old('sexo', $evento->sexo) === 'Desconocido' ? 'selected' : '' }}>Desconocido</option>
                </select>
                @error('sexo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Señas particulares --}}
            <div class="mb-4">
                <label for="senas_particulares" class="block font-medium">Señas particulares</label>
                <textarea id="senas_particulares" name="senas_particulares" class="w-full border rounded px-3 py-2" rows="3">{{ old('senas_particulares', $evento->senas_particulares) }}</textarea>
                @error('senas_particulares')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Código padres --}}
            <div class="mb-4">
                <label for="codigo_padres" class="block font-medium">Código de padres</label>
                <input type="text" id="codigo_padres" name="codigo_padres" class="w-full border rounded px-3 py-2" 
                    value="{{ old('codigo_padres', $evento->codigo_padres) }}">
                @error('codigo_padres')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- Campos para Deceso --}}
        @if(optional($evento->tipoEvento)->nombre === 'Deceso')
            {{-- Causas de deceso --}}
            <div class="mb-4">
                <label for="causas_deceso" class="block font-medium">Causas del deceso</label>
                <input type="text" id="causas_deceso" name="causas_deceso" class="w-full border rounded px-3 py-2" 
                    value="{{ old('causas_deceso', $evento->causas_deceso) }}" required>
                @error('causas_deceso')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tratamientos realizados --}}
            <div class="mb-4">
                <label for="tratamientos_realizados" class="block font-medium">Tratamientos realizados (si hubo)</label>
                <textarea id="tratamientos_realizados" name="tratamientos_realizados" class="w-full border rounded px-3 py-2" rows="3">{{ old('tratamientos_realizados', $evento->tratamientos_realizados) }}</textarea>
                @error('tratamientos_realizados')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- Observaciones --}}
        <div class="mb-4">
            <label for="observaciones" class="block font-medium">Observaciones</label>
            <textarea id="observaciones" name="observaciones" class="w-full border rounded px-3 py-2" rows="3">{{ old('observaciones', $evento->observaciones) }}</textarea>
            @error('observaciones')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto --}}
        <div class="mb-4">
            <label for="foto" class="block font-medium">Foto (opcional)</label>
            @if($evento->foto)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $evento->foto) }}" alt="Foto actual" class="h-24 rounded shadow">
                </div>
            @endif
            <input type="file" id="foto" name="foto" class="w-full border rounded px-3 py-2">
            @error('foto')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
            Actualizar Evento
        </button>
    </form>
</div>
@endsection
