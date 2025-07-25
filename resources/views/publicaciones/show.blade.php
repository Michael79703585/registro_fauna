@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6 bg-white rounded-lg shadow-md">

    {{-- Botón volver --}}
    <div class="mb-6">
        <a href="{{ route('publicaciones.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-green-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a publicaciones
        </a>
    </div>

    {{-- Título --}}
    <h1 class="text-4xl font-extrabold text-green-900 mb-2">{{ $publication->title }}</h1>

    {{-- Fecha --}}
    <p class="text-sm text-gray-500 mb-6">
        Publicado el: {{ $publication->created_at->format('d \d\e F, Y') }}
    </p>

    {{-- Descripción --}}
    <div class="prose prose-green max-w-none mb-10">
        {!! nl2br(e($publication->description)) !!}
    </div>

    {{-- Archivos --}}
    <section>
        <h2 class="text-2xl font-semibold text-green-800 mb-4">Archivos adjuntos</h2>
        @php
            $files = json_decode($publication->image_path, true);
        @endphp

        @if($files && count($files) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($files as $file)
                    <div class="border rounded-lg overflow-hidden shadow-sm bg-gray-50 p-4 flex flex-col items-center">
                        @if(Str::endsWith($file, ['.jpg', '.jpeg', '.png', '.webp']))
                            <img src="{{ asset('storage/' . $file) }}" alt="Imagen" class="max-h-64 object-contain rounded mb-4 w-full" />
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-green-700 hover:underline text-sm">Ver imagen completa</a>
                        @elseif(Str::endsWith($file, '.pdf'))
                            <embed src="{{ asset('storage/' . $file) }}" type="application/pdf" class="w-full h-64 rounded mb-4" />
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-green-700 hover:underline text-sm">Abrir PDF en nueva pestaña</a>
                        @else
                            <a href="{{ asset('storage/' . $file) }}" download class="text-green-700 hover:underline text-sm">Descargar archivo</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 italic">No hay archivos adjuntos.</p>
        @endif
    </section>

    {{-- Acciones del autor --}}
    @auth
    <div class="mt-10 flex gap-4">
        <a href="{{ route('publicaciones.edit', $publication->id) }}"
           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded transition text-sm">
            ✏️ Editar
        </a>

        <form action="{{ route('publicaciones.destroy', $publication->id) }}" method="POST"
              onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded transition text-sm">
                🗑️ Eliminar
            </button>
        </form>
    </div>
    @endauth

</div>
@endsection
