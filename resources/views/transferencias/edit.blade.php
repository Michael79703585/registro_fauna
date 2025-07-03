@extends('layouts.app')

@section('title', 'Editar Transferencia')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">✏️ Editar Transferencia</h2>

    @if($transferencia->estado != 'pendiente')
        <div class="bg-yellow-200 text-yellow-800 p-3 rounded mb-4">
            Esta transferencia ya fue <strong>{{ $transferencia->estado }}</strong> y no puede ser modificada ni eliminada.
        </div>
    @endif

    <form action="{{ route('transferencias.update', $transferencia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset {{ $transferencia->estado != 'pendiente' ? 'disabled' : '' }}>
            <div class="mb-4">
                <label for="fauna_id" class="block font-medium">Animal</label>
                <select name="fauna_id" id="fauna_id" required class="w-full border rounded p-2">
                    <option value="">Seleccione un animal</option>
                    @foreach ($faunas as $fauna)
                        <option value="{{ $fauna->id }}"
                            data-especie="{{ $fauna->especie }}"
                            data-nombre_comun="{{ $fauna->nombre_comun }}"
                            {{ $transferencia->fauna_id == $fauna->id ? 'selected' : '' }}>
                            {{ $fauna->codigo }} - {{ $fauna->especie }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <p class="italic text-gray-600" id="info-especie">
                    {{-- contenido dinámico --}}
                </p>
                <p class="text-gray-800 font-semibold" id="info-nombre">
                    {{-- contenido dinámico --}}
                </p>
            </div>

            <div class="mb-4">
    <label for="institucion_origen" class="block font-medium">Institución Origen</label>
    <select name="institucion_origen" class="w-full border rounded p-2" required>
        @foreach($instituciones as $institucion)
            <option value="{{ $institucion->id }}"
                {{ $transferencia->institucion_origen == $institucion->id ? 'selected' : '' }}>
                {{ $institucion->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="institucion_destino" class="block font-medium">Institución Destino</label>
    <select name="institucion_destino" class="w-full border rounded p-2" required>
        @foreach($instituciones as $institucion)
            <option value="{{ $institucion->nombre }}"
    {{ $transferencia->institucion_destino == $institucion->nombre ? 'selected' : '' }}>
    {{ $institucion->nombre }}
</option>
        @endforeach
    </select>
</div>

            <div class="mb-4">
                <label for="motivo" class="block font-medium">Motivo</label>
                <input type="text" name="motivo" value="{{ $transferencia->motivo }}" class="w-full border rounded p-2" />
            </div>

            <div class="mb-4">
                <label for="estado" class="block font-medium">Estado</label>
                <select name="estado" class="w-full border rounded p-2" required>
                    <option value="pendiente" {{ $transferencia->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aceptado" {{ $transferencia->estado == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                    <option value="rechazado" {{ $transferencia->estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="fecha_transferencia" class="block font-medium">Fecha de Transferencia</label>
                <input type="date" name="fecha_transferencia" value="{{ $transferencia->fecha_transferencia }}" class="w-full border rounded p-2" />
            </div>
        </fieldset>

        @if($transferencia->estado == 'pendiente')
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar Solicitud
            </button>
        @endif
    </form>

    {{-- Botones para PDF y Eliminar --}}
    <div class="mt-6 flex space-x-4">
        <a href="{{ route('transferencias.pdf', $transferencia->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Descargar PDF
        </a>

        @if($transferencia->estado == 'pendiente')
            <form action="{{ route('transferencias.destroy', $transferencia->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro que quieres eliminar esta transferencia?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Eliminar Registro
                </button>
            </form>
        @endif
    </div>
</div>

{{-- Script para mostrar especie y nombre común --}}
<script>
    function actualizarInfo() {
        const select = document.getElementById('fauna_id');
        const selected = select.options[select.selectedIndex];

        const especie = selected.getAttribute('data-especie');
        const nombre = selected.getAttribute('data-nombre_comun');

        document.getElementById('info-especie').innerText = especie ? `Especie: ${especie}` : '';
        document.getElementById('info-nombre').innerText = nombre ? `Nombre común: ${nombre}` : '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('fauna_id');
        select.addEventListener('change', actualizarInfo);
        actualizarInfo(); // Mostrar valores al cargar si ya hay uno seleccionado
    });
</script>
@endsection
