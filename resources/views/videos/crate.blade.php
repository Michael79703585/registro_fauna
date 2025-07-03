@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Agregar Video</h1>

    <form action="{{ route('videos.store') }}" method="POST" class="space-y-4 max-w-md">
        @csrf

        <div>
            <label for="title" class="block font-semibold mb-1">Título</label>
            <input type="text" name="title" id="title" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label for="url" class="block font-semibold mb-1">URL</label>
            <input type="url" name="url" id="url" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Guardar</button>
    </form>
</div>
@endsection
