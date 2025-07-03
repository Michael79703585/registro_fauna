@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">Editar Reporte #{{ $reporte->id }}</h1>

    @if ($errors->any())
        <div class="bg-red-100 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reportes.update', $reporte->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-semibold" for="tipo">Tipo de Reporte</label>
            <input type="text" id="tipo" name="tipo" value="{{ old('tipo', $reporte->tipo) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold" for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $reporte->fecha_inicio->format('Y-m-d')) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold" for="fecha_fin">Fecha de Fin</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', $reporte->fecha_fin->format('Y-m-d')) }}" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Actualizar</button>
            <a href="{{ route('reportes.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
