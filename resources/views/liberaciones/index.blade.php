@extends('layouts.app')

@section('title', 'Liberaciones de Fauna Silvestre')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-blue-700 pb-2">
            📋 REGISTROS DE LIBERACIÓN DE FAUNA SILVESTRE
        </h2>

        <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
            <a href="{{ route('liberaciones.create') }}"
               class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow text-sm font-semibold transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                ➕ Nuevo Registro
            </a>

            <div class="flex gap-2">
                <a href="{{ route('liberaciones.exportPdf') }}"
                   class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 11V3m0 0L8 7m4-4l4 4M6 21h12a2 2 0 002-2v-7H4v7a2 2 0 002 2z"/>
                    </svg>
                    Exportar PDF
                </a>

                <a href="{{ route('liberaciones.exportExcel') }}"
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4h16v16H4V4zm4 4l8 8m0-8l-8 8"/>
                    </svg>
                    Exportar Excel
                </a>
            </div>
        </div>

        {{-- Filtros --}}
        <form action="{{ route('liberaciones.index') }}" method="GET"
              class="mb-6 bg-gray-50 p-4 rounded-lg shadow border border-gray-200 flex flex-wrap gap-6 items-end">
            <div>
                <label for="codigo" class="block mb-1 font-medium text-sm text-gray-700">Buscar por código</label>
                <input type="text" name="codigo" id="codigo" placeholder="Código" value="{{ request('codigo') }}"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="fecha_inicio" class="block mb-1 font-medium text-sm text-gray-700">Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="fecha_fin" class="block mb-1 font-medium text-sm text-gray-700">Fecha fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-semibold transition duration-200">
                    Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="overflow-auto">
            <table class="min-w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-blue-50 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-3 py-2 border">Código</th>
                    <th class="px-3 py-2 border">Fecha</th>
                    <th class="px-3 py-2 border">Lugar</th>
                    <th class="px-3 py-2 border">Departamento</th>
                    <th class="px-3 py-2 border">Municipio</th>
                    <th class="px-3 py-2 border">Coordenadas</th>
                    <th class="px-3 py-2 border">Tipo Animal</th>
                    <th class="px-3 py-2 border">Especie</th>
                    <th class="px-3 py-2 border">Nombre Común</th>
                    <th class="px-3 py-2 border">Responsable</th>
                    <th class="px-3 py-2 border">Institución</th>
                    <th class="px-3 py-2 border">Observaciones</th>
                    <th class="px-3 py-2 border">Fotografía</th>
                    <th class="px-3 py-2 border">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($liberaciones as $liberacion)
                    <tr class="border-b hover:bg-blue-50 transition">
                        {{-- 1. Código --}}
                        <td class="px-3 py-2 border">{{ $liberacion->codigo }}</td>

                        {{-- 2. Fecha formateada --}}
                        <td class="px-3 py-2 border">
                            {{ \Carbon\Carbon::parse($liberacion->fecha)->format('d/m/Y') }}
                        </td>

                        {{-- 3. Lugar de liberación --}}
                        <td class="px-3 py-2 border">{{ $liberacion->lugar_liberacion }}</td>

                        {{-- 4. Departamento --}}
                        <td class="px-3 py-2 border">{{ $liberacion->departamento }}</td>

                        {{-- 5. Municipio --}}
                        <td class="px-3 py-2 border">{{ $liberacion->municipio }}</td>

                        {{-- 6. Coordenadas --}}
                        <td class="px-3 py-2 border">{{ $liberacion->coordenadas }}</td>

                        {{-- 7. Tipo de Animal --}}
                        <td class="px-3 py-2 border">{{ $liberacion->tipo_animal }}</td>

                        {{-- 8. Especie (cursiva) --}}
                        <td class="px-3 py-2 border italic">{{ $liberacion->especie }}</td>

                        {{-- 9. Nombre Común --}}
                        <td class="px-3 py-2 border">{{ $liberacion->nombre_comun }}</td>

                        {{-- 10. Responsable --}}
                        <td class="px-3 py-2 border">{{ $liberacion->responsable }}</td>

                        {{-- 11. Institución --}}
                        <td class="px-3 py-2 border">{{ $liberacion->institucion }}</td>

                        {{-- 12. Observaciones --}}
                        <td class="px-3 py-2 border">{{ $liberacion->observaciones }}</td>

                        {{-- 13. Fotografía --}}
<td class="px-3 py-2 border text-center">
    @php
        $rutaFoto = storage_path('app/public/' . $liberacion->foto);
    @endphp

    @if ($liberacion->foto && file_exists($rutaFoto))
        <img src="{{ asset('storage/' . $liberacion->foto) }}" alt="Foto de liberación"
             class="h-12 w-12 object-cover rounded">
    @else
        <span class="text-gray-400">Sin foto</span>
    @endif
</td>


                        {{-- Acciones --}}
<td class="px-3 py-2 border text-center">
    <div class="flex flex-wrap justify-center gap-1">
        {{-- Ver --}}
        <a href="{{ route('liberaciones.show', $liberacion->id) }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs shadow">
            Ver
        </a>

        {{-- PDF --}}
         <a href="{{ route('liberaciones.exportPdfIndividual', $liberacion->id) }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-600 text-white hover:bg-green-700 text-xs shadow transition"
           target="_blank" title="Descargar PDF">
            PDF
        </a>

        {{-- Editar --}}
        <a href="{{ route('liberaciones.edit', $liberacion->id) }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-xs shadow">
            Editar
        </a>

        {{-- Eliminar --}}
        <form action="{{ route('liberaciones.destroy', $liberacion->id) }}" method="POST"
              class="inline-block" onsubmit="return confirm('¿Eliminar este registro?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700 text-xs shadow">
                Eliminar
            </button>
        </form>
    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center px-4 py-6 text-gray-500">No hay registros disponibles.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-6 flex justify-center">
            {{ $liberaciones->links() }}
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigo = document.getElementById('codigo');
    if (codigo) {
        console.log('Valor del código:', codigo.value);
    } else {
        console.warn('Elemento #codigo no encontrado, evitando error');
    }
});
</script>
@endsection