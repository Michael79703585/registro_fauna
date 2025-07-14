@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <h1 class="text-3xl font-semibold mb-8 text-gray-800">🧾 Editar Parte/Derivado</h1>

    <div id="alerta" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <strong>¡Éxito!</strong> El formulario fue actualizado.
    </div>

    <div id="error" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <strong>¡Error!</strong> No se pudo actualizar el registro. Verifique los datos.
    </div>

    <input type="hidden" id="parte_id" value="{{ $parte->id }}">

    {{-- Código --}}
    <div class="mt-4">
        <label class="block text-gray-700 font-medium mb-2">Código</label>
        <input type="text" id="codigo" value="{{ $parte->codigo }}" class="w-full border rounded px-4 py-2" readonly>
    </div>

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
        <input type="text" id="coordenadas" value="{{ old('coordenadas', $registroDuplicado->coordenadas ?? '') }}" class="w-full border rounded px-4 py-2">
    </div>
    <div id="map" class="mt-4" style="height: 400px;"></div>

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
    const url = `{{ route('partes.update', ['parte' => ':id']) }}`.replace(':id', id);

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');
    formData.append('codigo', document.getElementById('codigo').value);
    formData.append('tipo_registro', document.getElementById('tipo_registro').value);
    formData.append('fecha_recepcion', document.getElementById('fecha_recepcion').value);
    formData.append('ciudad', document.getElementById('ciudad').value);
    formData.append('departamento', document.getElementById('departamento').value);
    formData.append('coordenadas', document.getElementById('coordenadas').value);
    formData.append('institucion_remitente', document.getElementById('institucion_remitente').value);
    formData.append('nombre_persona_recibe', document.getElementById('nombre_persona_recibe').value);
    formData.append('tipo_elemento', document.getElementById('tipo_elemento').value);
    formData.append('motivo_ingreso', document.getElementById('motivo_ingreso').value);
    formData.append('cantidad', document.getElementById('cantidad').value);
    formData.append('especie', document.getElementById('especie').value);
    formData.append('nombre_comun', document.getElementById('nombre_comun').value);
    formData.append('tipo_animal', document.getElementById('tipo_animal').value);
    formData.append('fecha', document.getElementById('fecha').value);
    formData.append('disposicion_final', document.getElementById('disposicion_final').value);
    formData.append('observaciones', document.getElementById('observaciones').value);

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('alerta').classList.remove('hidden');
            document.getElementById('error').classList.add('hidden');
        } else {
            document.getElementById('alerta').classList.add('hidden');
            document.getElementById('error').classList.remove('hidden');
        }
    })
    .catch(() => {
        document.getElementById('alerta').classList.add('hidden');
        document.getElementById('error').classList.remove('hidden');
    });
}
</script>

@endsection
