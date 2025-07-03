{{-- resources/views/liberaciones/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Liberación')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6 text-center">✏️ Editar Liberación</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('liberaciones.update', $liberacion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 1. Código --}}
        <div>
            <label for="codigo" class="block font-semibold mb-1">Código</label>
            <input type="text"
                   name="codigo"
                   id="codigo"
                   value="{{ old('codigo', $liberacion->codigo) }}"
                   required
                   class="w-full border px-4 py-2 rounded bg-gray-100"
                   readonly>
            {{-- Si no quieres permitir cambiar el código, déjalo readonly. --}}
        </div>

        {{-- 2. Fecha --}}
        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha</label>
            <input type="date"
                   name="fecha"
                   id="fecha"
                   value="{{ old('fecha', $liberacion->fecha) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 3. Lugar de liberación --}}
        <div>
            <label for="lugar_liberacion" class="block font-semibold mb-1">Lugar de Liberación</label>
            <input type="text"
                   name="lugar_liberacion"
                   id="lugar_liberacion"
                   value="{{ old('lugar_liberacion', $liberacion->lugar_liberacion) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 4. Departamento --}}
        <div>
            <label for="departamento" class="block font-semibold mb-1">Departamento</label>
            <input type="text"
                   name="departamento"
                   id="departamento"
                   value="{{ old('departamento', $liberacion->departamento) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 5. Municipio --}}
        <div>
            <label for="municipio" class="block font-semibold mb-1">Municipio</label>
            <input type="text"
                   name="municipio"
                   id="municipio"
                   value="{{ old('municipio', $liberacion->municipio) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 6. Coordenadas --}}
        <div>
            <label for="coordenadas" class="block font-semibold mb-1">Coordenadas</label>
            <input type="text"
                   name="coordenadas"
                   id="coordenadas"
                   value="{{ old('coordenadas', $liberacion->coordenadas) }}"
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 7. Tipo de Animal --}}
        <div>
            <label for="tipo_animal" class="block font-semibold mb-1">Tipo de Animal</label>
            <input type="text"
                   name="tipo_animal"
                   id="tipo_animal"
                   value="{{ old('tipo_animal', $liberacion->tipo_animal) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 8. Especie --}}
        <div>
            <label for="especie" class="block font-semibold mb-1">Especie</label>
            <input type="text"
                   name="especie"
                   id="especie"
                   value="{{ old('especie', $liberacion->especie) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 9. Nombre Común --}}
        <div>
            <label for="nombre_comun" class="block font-semibold mb-1">Nombre Común</label>
            <input type="text"
                   name="nombre_comun"
                   id="nombre_comun"
                   value="{{ old('nombre_comun', $liberacion->nombre_comun) }}"
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 10. Responsable --}}
        <div>
            <label for="responsable" class="block font-semibold mb-1">Responsable</label>
            <input type="text"
                   name="responsable"
                   id="responsable"
                   value="{{ old('responsable', $liberacion->responsable) }}"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        {{-- 11. Institución (solo lectura) --}}
        <div>
            <label for="institucion" class="block font-semibold mb-1">Institución</label>
            <input type="text"
                   id="institucion"
                   name="institucion"
                   readonly
                   value="{{ old('institucion', $liberacion->institucion) }}"
                   class="w-full border px-4 py-2 rounded bg-gray-100">
        </div>

        {{-- 12. Observaciones --}}
        <div>
            <label for="observaciones" class="block font-semibold mb-1">Observaciones</label>
            <textarea name="observaciones"
                      id="observaciones"
                      rows="3"
                      class="w-full border px-4 py-2 rounded">{{ old('observaciones', $liberacion->observaciones) }}</textarea>
        </div>

        {{-- 13. Fotografía --}}
        <div>
            <label for="foto" class="block font-semibold mb-1">Fotografía</label>
            <input type="file"
                   name="foto"
                   id="foto"
                   class="w-full border px-4 py-2 rounded bg-white 
                          file:mr-4 file:py-2 file:px-4 file:border-0 
                          file:text-sm file:bg-blue-100 file:text-blue-700 
                          hover:file:bg-blue-200">
            @if ($liberacion->foto)
                <p class="mt-2">
                    Foto actual:
                    <a href="{{ asset('storage/' . $liberacion->foto) }}" target="_blank" class="text-blue-500 underline">
                        Ver imagen
                    </a>
                </p>
            @endif
        </div>

        {{-- Botones --}}
        <div class="flex justify-between items-center mt-6 max-w-md mx-auto p-4 bg-white rounded shadow">
            <a href="{{ route('liberaciones.index') }}"
               class="text-blue-600 font-semibold hover:text-blue-800 hover:underline transition-colors duration-300">
                ← Cancelar
            </a>

            <button type="submit"
                    class="bg-yellow-600 text-white font-semibold px-6 py-2 rounded shadow-md 
                           hover:bg-yellow-700 hover:scale-105 transform transition duration-300 ease-in-out
                           focus:outline-none focus:ring-4 focus:ring-yellow-300">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
