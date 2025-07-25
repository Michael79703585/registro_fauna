@extends('layouts.app')

@section('content')
<section class="bg-gray-100 py-12">
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">✏️ Editar publicación</h2>

    <form action="{{ route('publicaciones.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Título -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
        <input type="text" name="title" value="{{ old('title', $publication->title) }}"
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-400"
               required>
      </div>

      <!-- Descripción -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
        <textarea name="description" rows="4"
                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-400"
                  required>{{ old('description', $publication->description) }}</textarea>
      </div>

      <!-- Archivos existentes -->
      <div class="mb-6">
        <p class="font-semibold text-gray-700 mb-2">Archivos actuales:</p>
        <div class="space-y-6">
          @foreach ($publication->image_path as $index => $file)
            @php $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); @endphp

            <div class="border p-3 rounded-md shadow-sm">
              @if (in_array($ext, ['jpg','jpeg','png','webp']))
                <img src="{{ asset('storage/' . $file) }}" alt="Imagen" class="max-w-full h-auto rounded shadow mb-2">
              @elseif ($ext === 'pdf')
                <embed src="{{ asset('storage/' . $file) }}" type="application/pdf" width="100%" height="300px" class="rounded shadow mb-2">
              @else
                <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-blue-600 underline block mb-2">
                  Ver archivo
                </a>
              @endif

              <!-- Botón para eliminar archivo -->
              <form action="{{ route('publicaciones.file.destroy', [$publication->id, $index]) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este archivo?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 text-sm hover:underline">
                  🗑️ Eliminar archivo
                </button>
              </form>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Cargar nuevos archivos -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Agregar más archivos (opcional)</label>
        <input type="file" name="files[]" multiple
               class="block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100">
      </div>

      <!-- Botón Guardar -->
      <div class="text-right">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          💾 Guardar cambios
        </button>
      </div>
    </form>
  </div>
</section>
@endsection
