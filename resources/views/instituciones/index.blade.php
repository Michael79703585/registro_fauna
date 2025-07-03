@extends('layouts.app')

@section('title', 'Lista de Instituciones')

@section('content')
    <div class="max-w-4xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-blue-700">🏛️ Instituciones Registradas</h2>

        @if($instituciones->isEmpty())
            <p class="text-gray-600">No hay instituciones registradas aún.</p>
        @else
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-blue-800">
                        <th class="text-left px-4 py-2">#</th>
                        <th class="text-left px-4 py-2">Nombre</th>
                        <th class="text-left px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instituciones as $index => $institucion)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $institucion->nombre }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('instituciones.edit', $institucion->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded font-semibold">
                                    ✏️ Editar
                                </a>

                                <form action="{{ route('instituciones.destroy', $institucion->id) }}" method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta institución?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded font-semibold">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-6">
            <a href="{{ route('instituciones.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                ➕ Nueva Institución
            </a>
        </div>
    </div>
@endsection
