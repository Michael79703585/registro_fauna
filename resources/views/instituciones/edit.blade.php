@extends('layouts.app')

@section('title', 'Editar Institución')

@section('content')
    <div class="max-w-md mx-auto mt-8 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-blue-700">✏️ Editar Institución</h2>

        <form action="{{ route('instituciones.update', $institucion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block font-semibold mb-1">Nombre de la Institución:</label>
                <input type="text" name="nombre" id="nombre" 
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('nombre', $institucion->nombre) }}" required>
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">
                Guardar Cambios
            </button>
        </form>
    </div>
@endsection
