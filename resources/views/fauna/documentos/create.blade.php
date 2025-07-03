
@extends('layouts.app')

@section('title', 'Subir Documento de Fauna')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-blue-800">📌 Subir Documento para Fauna - {{ \$fauna->codigo }}</h2>
        <p class="text-sm text-gray-600 mb-4">Adjunta aquí informes, remisiones u otros documentos del ejemplar.</p>

        @if(\$errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>¡Ups!</strong> Hay algunos problemas:
                <ul class="mt-2 list-disc list-inside">
                    @foreach(\$errors->all() as \$error)
                        <li class="text-sm">{{ \$error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fauna.documentos.store', \$fauna->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow">
            @csrf

            <div class="mb-4">
                <label for="tipo_documento" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                <input type="text" name="tipo_documento" id="tipo_documento" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ej. Informe Veterinario, Remisión...">
            </div>

            <div class="mb-4">
                <label for="archivo" class="block text-sm font-medium text-gray-700">Archivo</label>
                <input type="file" name="archivo" id="archivo" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('fauna.documentos.index', \$fauna->id) }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                    Subir Documento
                </button>
            </div>
        </form>
    </div>
@endsection
