@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nueva publicación</h2>

    <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow">
        @csrf
        <div>
            <label class="block font-semibold text-sm mb-1">Título</label>
            <input type="text" name="title" required class="w-full border px-3 py-2 rounded" />
        </div>
        <div>
            <label class="block font-semibold text-sm mb-1">Descripción</label>
            <textarea name="description" rows="4" required class="w-full border px-3 py-2 rounded"></textarea>
        </div>
        <div>
            <label class="block font-semibold text-sm mb-1">Imágenes o archivos (puedes subir varios)</label>
            <input type="file" name="files[]" multiple class="w-full border px-3 py-2 rounded" />
        </div>
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">Publicar</button>
        </div>
    </form>
</div>
@endsection
