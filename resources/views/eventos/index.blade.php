@extends('layouts.app')

@section('title', 'Lista de Eventos')

@section('content')
<div class="w-full min-h-screen bg-white py-100 px-100">
    <div class="max-w-7xl mx-auto shadow rounded-lg bg-white">
        <h2 class="text-2xl font-bold mb-6">📌 EVENTOS RECIENTES</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex flex-wrap gap-3">
            <a href="{{ route('eventos.create', ['tipo' => 'Nacimiento']) }}" class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700 transition">
                🐣 Nuevo Nacimiento
            </a>
            <a href="{{ route('eventos.create', ['tipo' => 'Fuga']) }}" class="px-4 py-2 bg-yellow-500 text-black rounded hover:bg-yellow-600 transition">
                🏃 Nueva Fuga
            </a>
            <a href="{{ route('eventos.create', ['tipo' => 'Deceso']) }}" class="px-4 py-2 bg-red-600 text-black rounded hover:bg-red-700 transition">
                🕊️ Nuevo Deceso
            </a>
        </div>

        <div class="overflow-x-auto max-h-[75vh] border border-gray-300 rounded">
            <table class="w-full table-auto border-collapse text-sm">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="text-center">
                        <th class="border border-gray-300 px-2 py-2">Código</th>
                        <th class="border border-gray-300 px-2 py-2">Tipo Evento</th>
                        <th class="border border-gray-300 px-2 py-2">Fecha</th>
                        <th class="border border-gray-300 px-2 py-2">Especie</th>
                        <th class="border border-gray-300 px-2 py-2">Nombre Común</th>
                        <th class="border border-gray-300 px-2 py-2">Institución</th>
                        <th class="border border-gray-300 px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventos as $evento)
                        <tr class="text-center even:bg-gray-50">
                            <td class="border border-gray-300 px-2 py-2">{{ $evento->codigo }}</td>
                            <td class="border border-gray-300 px-2 py-2">{{ $evento->tipoEvento->nombre ?? '-' }}</td>
                            <td class="border border-gray-300 px-2 py-2">{{ optional($evento->fecha)->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-2 py-2 italic">{{ $evento->especie ?? 'N/A' }}</td>

                            <td class="border border-gray-300 px-2 py-2">{{ $evento->nombre_comun ?? 'N/A' }}</td>
                            <td class="border border-gray-300 px-2 py-2">{{ $evento->institucion->nombre ?? 'N/A' }}</td>
                            <td class="border border-gray-300 px-2 py-2 space-y-1">
                                <a href="{{ route('eventos.exportar_pdf_individual', $evento->id) }}" class="text-indigo-600 hover:underline block">📄 PDF</a>
                                <a href="{{ route('eventos.show', $evento->id) }}" class="text-blue-600 hover:underline block">👁️ Ver</a>
                                <a href="{{ route('eventos.edit', $evento->id) }}" class="text-yellow-600 hover:underline block">✏️ Editar</a>
                                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este evento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                No hay eventos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $eventos->links() }}
        </div>
    </div>
</div>
@endsection
