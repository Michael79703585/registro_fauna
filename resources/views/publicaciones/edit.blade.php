@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-green-900">Editar Publicación</h2>

    <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block font-semibold text-green-900 mb-1">Título</label>
            <input type="text" name="title" id="title" value="{{ old('title', $publicacion->title) }}" required
                class="w-full border border-green-300 rounded px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" />
            @error('title')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-semibold text-green-900 mb-1">Descripción</label>
            <textarea name="description" id="description" rows="4" required
                class="w-full border border-green-300 rounded px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none">{{ old('description', $publicacion->description) }}</textarea>
            @error('description')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mostrar imágenes actuales -->
        @if (is_array($publicacion->image_path ?? null))
            <div>
                <label class="block font-semibold text-green-900 mb-1">Imágenes Actuales</label>
                <div class="flex gap-4 flex-wrap">
                    @foreach ($publicacion->image_path as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="Imagen actual" class="h-32 rounded shadow" />
                    @endforeach
                </div>
            </div>
        @elseif ($publicacion->image_path)
            <div>
                <label class="block font-semibold text-green-900 mb-1">Imagen Actual</label>
                <img src="{{ asset('storage/' . $publicacion->image_path) }}" alt="Imagen actual" class="mb-4 max-h-48 rounded" />
            </div>
        @endif

        <div>
            <label for="images" class="block font-semibold text-green-900 mb-1">Cambiar Imágenes (puedes seleccionar varias)</label>
            <input type="file" name="images[]" id="images" accept="image/*" multiple
                class="w-full border border-green-300 rounded px-4 py-2 focus:ring-2 focus:ring-green-600 focus:outline-none" />
            @error('images')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
    style="background-color: #065f46; color: white; padding: 12px 24px; border-radius: 12px; border: none; font-weight: bold;"
    onmouseover="this.style.backgroundColor='#047857'"
    onmouseout="this.style.backgroundColor='#065f46'">
    Actualizar
</button>
    </form>
</div>
@endsection
