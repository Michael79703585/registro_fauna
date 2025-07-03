@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Videos</h1>
    <a href="{{ route('videos.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Agregar Video</a>

    @if($videos->count())
        <ul>
            @foreach($videos as $video)
                <li class="mb-2">
                    <strong>{{ $video->title }}</strong> - 
                    <a href="{{ $video->url }}" target="_blank" class="text-blue-600 underline">Ver video</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay videos disponibles.</p>
    @endif
</div>
@endsection
