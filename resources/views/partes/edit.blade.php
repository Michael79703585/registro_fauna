@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <h1 class="text-3xl font-semibold mb-8 text-gray-800">🧾 Editar Parte/Derivado</h1>

    <div id="alerta" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <strong>¡Éxito!</strong> El formulario fue actualizado.
    </div>

    <input type="hidden" id="parte_id" value="{{ $parte->id }}">


    {{-- Tipo de Registro --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Tipo de Registro</label>
        <input type="text" id="tipo_registro" value="{{ $parte->tipo_registro }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Fecha de Recepción --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Fecha de Recepción</label>
        <input type="date" id="fecha_recepcion" value="{{ $parte->fecha_recepcion }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Ciudad --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Ciudad</label>
        <input type="text" id="ciudad" value="{{ $parte->ciudad }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Departamento --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Departamento</label>
        <input type="text" id="departamento" value="{{ $parte->departamento }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Coordenadas --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Coordenadas</label>
        <input type="text" id="coordenadas" value="{{ $parte->coordenadas }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Institución Remitente --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Institución</label>
        <input type="text" id="institucion_remitente" value="{{ $parte->institucion_remitente }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Nombre Persona que Recibe --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Nombre Persona que Recibe</label>
        <input type="text" id="nombre_persona_recibe" value="{{ $parte->nombre_persona_recibe }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Tipo de Elemento --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Tipo de Elemento</label>
        <input type="text" id="tipo_elemento" value="{{ $parte->tipo_elemento }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Motivo de Ingreso --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Motivo de Ingreso</label>
        <input type="text" id="motivo_ingreso" value="{{ $parte->motivo_ingreso }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Cantidad --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Cantidad</label>
        <input type="number" id="cantidad" value="{{ $parte->cantidad }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Especie --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Especie</label>
        <input type="text" id="especie" value="{{ $parte->especie }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Nombre Común --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Nombre Común</label>
        <input type="text" id="nombre_comun" value="{{ $parte->nombre_comun }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Tipo de Animal --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Tipo de Animal</label>
        <input type="text" id="tipo_animal" value="{{ $parte->tipo_animal }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Fecha de Disposición --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Fecha de Disposición</label>
        <input type="date" id="fecha" value="{{ $parte->fecha }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Disposición Final --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Disposición Final</label>
        <input type="text" id="disposicion_final" value="{{ $parte->disposicion_final }}" class="w-full border rounded px-4 py-2">
    </div>

    {{-- Observaciones --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Observaciones</label>
        <textarea id="observaciones" class="w-full border rounded px-4 py-2">{{ $parte->observaciones }}</textarea>
    </div>

    <div class="flex space-x-4 mt-6">
        <button onclick="guardarParte()" class="bg-blue-600 text-white px-6 py-3 rounded shadow hover:bg-blue-700">Guardar</button>
        <a href="{{ route('partes.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded shadow hover:bg-gray-600">Volver</a>
    </div>
</div>

<script>
    function guardarParte() {
        const id = document.getElementById('parte_id').value;

        const data = {
            _method: 'PATCH',
            _token: '{{ csrf_token() }}',
            codigo: document.getElementById('codigo').value,
            tipo_registro: document.getElementById('tipo_registro').value,
            fecha_recepcion: document.getElementById('fecha_recepcion').value,
            ciudad: document.getElementById('ciudad').value,
            departamento: document.getElementById('departamento').value,
            coordenadas: document.getElementById('coordenadas').value,
            institucion_remitente: document.getElementById('institucion_remitente').value,
            nombre_persona_recibe: document.getElementById('nombre_persona_recibe').value,
            tipo_elemento: document.getElementById('tipo_elemento').value,
            motivo_ingreso: document.getElementById('motivo_ingreso').value,
            cantidad: document.getElementById('cantidad').value,
            especie: document.getElementById('especie').value,
            nombre_comun: document.getElementById('nombre_comun').value,
            tipo_animal: document.getElementById('tipo_animal').value,
            fecha: document.getElementById('fecha').value,
            disposicion_final: document.getElementById('disposicion_final').value,
            observaciones: document.getElementById('observaciones').value
        };

        fetch(`/partes/${id}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        }).then(response => {
            if (response.ok) {
                document.getElementById('alerta').classList.remove('hidden');
            } else {
                alert('Error al guardar los datos');
            }
        }).catch(() => alert('Error al guardar'));
    }
</script>
@endsection
