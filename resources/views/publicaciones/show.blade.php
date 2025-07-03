@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6 bg-white rounded-lg shadow-md">
    {{-- Título --}}
    <h1 class="text-4xl font-extrabold text-green-900 mb-4">{{ $publication->title }}</h1>

    {{-- Fecha de creación --}}
    <p class="text-sm text-gray-500 mb-8">
        Publicado el: {{ $publication->created_at->format('d \d\e F, Y') }}
    </p>

    {{-- Descripción --}}
    <div class="prose prose-green max-w-none mb-8">
        <p>{{ $publication->description }}</p>
    </div>

    <hr class="border-green-300 mb-8">

    {{-- Archivos adjuntos --}}
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
                            <img src="{{ asset('storage/' . $file) }}" alt="Imagen adjunta" class="max-h-64 object-contain rounded-md mb-4 w-full" />
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-green-700 hover:underline text-sm">Ver imagen en tamaño completo</a>
                        @elseif(Str::endsWith($file, ['.pdf']))
                            <embed src="{{ asset('storage/' . $file) }}" type="application/pdf" class="w-full h-64 rounded-md mb-4" />
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-green-700 hover:underline text-sm">Abrir PDF en nueva pestaña</a>
                        @else
                            <a href="{{ asset('storage/' . $file) }}" download class="text-green-700 hover:underline text-sm">
                                Descargar archivo
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 italic">No hay archivos adjuntos para esta publicación.</p>
        @endif
    </section>
</div>
@endsection
