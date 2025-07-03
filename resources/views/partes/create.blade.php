@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <h1 class="text-3xl font-semibold mb-8 text-gray-800">Registrar Nueva Parte/Derivado</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong>¡Ups!</strong> Hay problemas con la información proporcionada.
            <ul class="list-disc list-inside mt-2 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('partes.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Código generado automáticamente --}}
        <div class="mb-4">
            <label for="codigo" class="block text-gray-700 font-medium mb-2">Código *</label>
            <input type="text" id="codigo" name="codigo" 
                   value="{{ $codigoGenerado ?? old('codigo', $registroDuplicado->codigo ?? '') }}" 
                   readonly 
                   class="w-full bg-gray-100 border border-gray-300 rounded px-4 py-2 text-gray-600 cursor-not-allowed">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="tipo_registro" class="block mb-2 font-medium text-gray-700">Tipo de Registro *</label>
                <select name="tipo_registro" id="tipo_registro" required
                        class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
                    <option value="" disabled {{ old('tipo_registro', $registroDuplicado->tipo_registro ?? '') == '' ? 'selected' : '' }}>Seleccione...</option>
                    <option value="animal_muerto" {{ old('tipo_registro', $registroDuplicado->tipo_registro ?? '') == 'animal_muerto' ? 'selected' : '' }}>Animal Muerto</option>
                    <option value="parte" {{ old('tipo_registro', $registroDuplicado->tipo_registro ?? '') == 'parte' ? 'selected' : '' }}>Parte</option>
                    <option value="derivado" {{ old('tipo_registro', $registroDuplicado->tipo_registro ?? '') == 'derivado' ? 'selected' : '' }}>Derivado</option>
                </select>
            </div>

            <div>
                <label for="fecha_recepcion" class="block mb-2 font-medium text-gray-700">Fecha de Recepción *</label>
                <input type="date" id="fecha_recepcion" name="fecha_recepcion" required
                       value="{{ old('fecha_recepcion', $registroDuplicado->fecha_recepcion ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            <div>
                <label for="ciudad" class="block mb-2 font-medium text-gray-700">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" maxlength="100"
                       value="{{ old('ciudad', $registroDuplicado->ciudad ?? '') }}"
                       placeholder="Ej: Cochabamba"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label for="departamento" class="block mb-2 font-medium text-gray-700">Departamento</label>
                <input type="text" id="departamento" name="departamento" maxlength="100"
                       value="{{ old('departamento', $registroDuplicado->departamento ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            <div>
                <label for="coordenadas" class="block mb-2 font-medium text-gray-700">Coordenadas</label>
                <input type="text" id="coordenadas" name="coordenadas" maxlength="100"
                       value="{{ old('coordenadas', $registroDuplicado->coordenadas ?? '') }}"
                       placeholder="Ej: 4.7110° N, 74.0721° W"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>
        </div>

        {{-- Institución remitente --}}
        <div class="mt-6">
            <label for="institucion_remitente" class="block text-gray-700 font-medium mb-2">Institución *</label>
            <input type="text" id="institucion_remitente" name="institucion_remitente"
                   value="{{ old('institucion_remitente', $institucionNombre ?? $registroDuplicado->institucion_remitente ?? '') }}" readonly
                   class="w-full bg-gray-100 border border-gray-300 rounded px-4 py-2 text-gray-600 cursor-not-allowed">
        </div>

        {{-- Nombre persona que recibe --}}
        <div class="mt-4">
            <label for="nombre_persona_recibe" class="block text-gray-700 font-medium mb-2">Nombre Persona que Recibe *</label>
            <input type="text" id="nombre_persona_recibe" name="nombre_persona_recibe" required
                   value="{{ old('nombre_persona_recibe', $registroDuplicado->nombre_persona_recibe ?? '') }}"
                   class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label for="tipo_elemento" class="block mb-2 font-medium text-gray-700">Tipo de Elemento</label>
                <input type="text" id="tipo_elemento" name="tipo_elemento" maxlength="50"
                       value="{{ old('tipo_elemento', $registroDuplicado->tipo_elemento ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            <div>
                <label for="motivo_ingreso" class="block mb-2 font-medium text-gray-700">Motivo de Ingreso</label>
                <select id="motivo_ingreso" name="motivo_ingreso"
                        class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
                    <option value="">Seleccione...</option>
                    <option value="decomiso" {{ old('motivo_ingreso', $registroDuplicado->motivo_ingreso ?? '') == 'decomiso' ? 'selected' : '' }}>Decomiso</option>
                    <option value="rescate" {{ old('motivo_ingreso', $registroDuplicado->motivo_ingreso ?? '') == 'rescate' ? 'selected' : '' }}>Rescate</option>
                    <option value="otro" {{ old('motivo_ingreso', $registroDuplicado->motivo_ingreso ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
        </div>

        <div class="mt-6">
            <label for="cantidad" class="block mb-2 font-medium text-gray-700">Cantidad *</label>
            <input type="number" id="cantidad" name="cantidad" min="1" required
                   value="{{ old('cantidad', $registroDuplicado->cantidad ?? 1) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div>
                <label for="especie" class="block mb-2 font-medium text-gray-700">Especie *</label>
                <input type="text" id="especie" name="especie" maxlength="100" required
                       value="{{ old('especie', $registroDuplicado->especie ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            <div>
                <label for="nombre_comun" class="block mb-2 font-medium text-gray-700">Nombre Común</label>
                <input type="text" id="nombre_comun" name="nombre_comun" maxlength="100"
                       value="{{ old('nombre_comun', $registroDuplicado->nombre_comun ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            <div>
                <label for="tipo_animal" class="block mb-2 font-medium text-gray-700">Tipo de Animal</label>
                <select id="tipo_animal" name="tipo_animal"
                        class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
                    <option value="">Seleccione...</option>
                    <option value="mamifero" {{ old('tipo_animal', $registroDuplicado->tipo_animal ?? '') == 'mamifero' ? 'selected' : '' }}>Mamífero</option>
                    <option value="ave" {{ old('tipo_animal', $registroDuplicado->tipo_animal ?? '') == 'ave' ? 'selected' : '' }}>Ave</option>
                    <option value="reptil" {{ old('tipo_animal', $registroDuplicado->tipo_animal ?? '') == 'reptil' ? 'selected' : '' }}>Reptil</option>
                    <option value="anfibio" {{ old('tipo_animal', $registroDuplicado->tipo_animal ?? '') == 'anfibio' ? 'selected' : '' }}>Anfibio</option>
                    <option value="otro" {{ old('tipo_animal', $registroDuplicado->tipo_animal ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label for="fecha" class="block mb-2 font-medium text-gray-700">Fecha de Disposición *</label>
                <input type="date" id="fecha" name="fecha" required
                       value="{{ old('fecha', $registroDuplicado->fecha ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>

            <div>
                <label for="disposicion_final" class="block mb-2 font-medium text-gray-700">Disposición Final</label>
                <input type="text" id="disposicion_final" name="disposicion_final" maxlength="255"
                       value="{{ old('disposicion_final', $registroDuplicado->disposicion_final ?? '') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">
            </div>
        </div>

        <div class="mt-6">
            <label for="observaciones" class="block mb-2 font-medium text-gray-700">Observaciones</label>
            <textarea id="observaciones" name="observaciones" rows="4"
                      class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm">{{ old('observaciones', $registroDuplicado->observaciones ?? '') }}</textarea>
        </div>

        {{-- Foto drag & drop --}}
        <div class="mt-6">
            <label class="block mb-2 font-medium text-gray-700">Foto</label>
            <div id="dropzone" class="border-2 border-dashed border-gray-400 rounded p-6 text-center cursor-pointer hover:border-blue-500 transition relative">
                <p class="text-gray-600 mb-2">Arrastra una imagen aquí o haz clic para seleccionar</p>
                <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                <img id="preview" src="#" alt="Vista previa" class="mx-auto max-h-48 hidden rounded mt-4" />
                <button type="button" id="removeImage" 
                        class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition hidden">
                    Eliminar
                </button>
            </div>
        </div>

        <div class="flex space-x-4 mt-6">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded shadow hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition transform hover:scale-105">
                Guardar
            </button>
            <a href="{{ route('partes.index') }}" 
               class="inline-block px-6 py-3 border border-gray-400 rounded text-gray-700 hover:bg-gray-100 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropzone = document.getElementById('dropzone');
    const inputFile = document.getElementById('foto');
    const preview = document.getElementById('preview');
    const removeBtn = document.getElementById('removeImage');

    dropzone.addEventListener('click', () => inputFile.click());

    dropzone.addEventListener('dragover', e => {
        e.preventDefault();
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropzone.addEventListener('dragleave', e => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
        if (e.dataTransfer.files.length) {
            inputFile.files = e.dataTransfer.files;
            previewImage(e.dataTransfer.files[0]);
        }
    });

    inputFile.addEventListener('change', () => {
        if (inputFile.files.length) {
            previewImage(inputFile.files[0]);
        }
    });

    removeBtn.addEventListener('click', () => {
        inputFile.value = '';
        preview.src = '#';
        preview.classList.add('hidden');
        removeBtn.classList.add('hidden');
    });

    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            removeBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
