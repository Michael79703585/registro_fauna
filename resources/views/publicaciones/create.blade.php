@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-green-900">Crear Nueva Publicación</h2>

    <form action="{{ route('publication.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="title" class="block font-semibold text-green-900 mb-1">Título</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full border border-green-300 rounded px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" />
            @error('title')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-semibold text-green-900 mb-1">Descripción</label>
            <textarea name="description" id="description" rows="4" required
                class="w-full border border-green-300 rounded px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="images" class="block font-semibold text-green-900 mb-1">Imágenes (puedes subir varias)</label>
            <input type="file" name="images[]" id="images" accept="image/*" multiple
                class="w-full border border-green-300 rounded px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" />
            @error('images')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-green-800 hover:bg-green-900 text-white font-bold px-6 py-3 rounded shadow transition w-full">
            Publicar
        </button>
    </form>
</div>
@endsection
