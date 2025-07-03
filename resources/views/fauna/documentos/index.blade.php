@extends('layouts.app')

@section('title', 'Documentos de Fauna Recepcionada')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-blue-800">Documentos adjuntos - {{ \$fauna->codigo }}</h2>
        <p class="text-sm text-gray-600 mb-4">Aquí puedes ver, descargar o eliminar documentos relacionados con este ejemplar de fauna.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <a href="{{ route('fauna.documentos.create', \$fauna->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                ➕ Subir nuevo documento
            </a>
            <a href="{{ route('fauna.index') }}" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded">
                ⬅ Volver a Faunas
            </a>
        </div>

        @if(\$documentos->count())
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 bg-white shadow rounded">
                    <thead class="bg-blue-100 text-blue-900 font-semibold">
                        <tr>
                            <th class="py-2 px-4 border-b">Nombre</th>
                            <th class="py-2 px-4 border-b">Tipo de Documento</th>
                            <th class="py-2 px-4 border-b">Subido</th>
                            <th class="py-2 px-4 border-b">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\$documentos as \$doc)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b">{{ \$doc->nombre_archivo }}</td>
                                <td class="py-2 px-4 border-b">{{ \$doc->tipo_documento ?? 'Sin especificar' }}</td>
                                <td class="py-2 px-4 border-b">{{ \$doc->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-2 px-4 border-b flex gap-2">
                                    <a href="{{ route('fauna.documentos.download', \$doc->id) }}" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded">
                                        Descargar
                                    </a>
                                    <form action="{{ route('fauna.documentos.destroy', \$doc->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este documento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 mt-4">No hay documentos registrados aún para este ejemplar.</p>
        @endif
    </div>
@endsection
