@extends('layouts.app')

@section('title', 'Listado de Partes')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-blue-700 pb-2">
        📋 REGISTRO DE PARTES
    </h2>

    <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
        <a href="{{ route('partes.create') }}"
            class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow text-sm font-semibold transition-all">
            ➕ Nuevo Registro
        </a>

        <div class="flex gap-2">
            <a href="{{ route('partes.exportPdf') }}"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all">
                Exportar PDF
            </a>

            <a href="{{ route('partes.exportExcel') }}"
                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all">
                Exportar Excel
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <form action="{{ route('partes.index') }}" method="GET"
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
                    <th class="px-3 py-2 border">Tipo Registro</th>
                    <th class="px-3 py-2 border">Fecha Recepción</th>
                    <th class="px-3 py-2 border">Ciudad</th>
                    <th class="px-3 py-2 border">Departamento</th>
                    <th class="px-3 py-2 border">Coordenadas</th>
                    <th class="px-3 py-2 border">Tipo Elemento</th>
                    <th class="px-3 py-2 border">Motivo Ingreso</th>
                    <th class="px-3 py-2 border">Institución</th>
                    <th class="px-3 py-2 border">Persona que Recibe</th>
                    <th class="px-3 py-2 border italic">Especie</th>
                    <th class="px-3 py-2 border">Nombre Común</th>
                    <th class="px-3 py-2 border">Tipo Animal</th>
                    <th class="px-3 py-2 border">Cantidad</th>
                    <th class="px-3 py-2 border">Fecha</th>
                    <th class="px-3 py-2 border">Disposición Final</th>
                    <th class="px-3 py-2 border">Observaciones</th>
                    <th class="px-3 py-2 border text-center">Foto</th> <!-- Nueva columna -->
                    <th class="px-3 py-2 border text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($partes as $parte)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="px-3 py-2 border">{{ $parte->codigo ?? 'N/A' }}</td>
                        <td class="px-3 py-2 border">{{ ucfirst(str_replace('_', ' ', $parte->tipo_registro)) }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($parte->fecha_recepcion)->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 border">{{ $parte->ciudad }}</td>
                        <td class="px-3 py-2 border">{{ $parte->departamento }}</td>
                        <td class="px-3 py-2 border">{{ $parte->coordenadas }}</td>
                        <td class="px-3 py-2 border">{{ $parte->tipo_elemento }}</td>
                        <td class="px-3 py-2 border">{{ $parte->motivo_ingreso }}</td>
                        <td class="px-3 py-2 border">{{ $parte->institucion_remitente }}</td>
                        <td class="px-3 py-2 border">{{ $parte->nombre_persona_recibe }}</td>
                        <td class="px-3 py-2 border italic">{{ $parte->especie }}</td>
                        <td class="px-3 py-2 border">{{ $parte->nombre_comun }}</td>
                        <td class="px-3 py-2 border">{{ $parte->tipo_animal }}</td>
                        <td class="px-3 py-2 border">{{ $parte->cantidad }}</td>
                        <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($parte->fecha)->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 border">{{ $parte->disposicion_final }}</td>
                        <td class="px-3 py-2 border">{{ $parte->observaciones }}</td>

                        <td class="px-3 py-2 border text-center">
    @if ($parte->foto && file_exists(public_path('storage/partes_fotos/' . $parte->foto)))
    <img src="{{ asset('storage/partes_fotos/' . $parte->foto) }}" alt="Foto" class="w-32 h-32 rounded shadow">
@else
    <p class="text-gray-500 italic">Foto no disponible</p>
@endif



</td>


                        <td class="px-3 py-2 border text-center flex flex-col items-center space-y-2">
    <a href="{{ route('partes.show', $parte->id) }}"
        class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs shadow">
        Ver
    </a>

    <a href="{{ route('partes.pdf', $parte->id) }}"
        class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-600 text-white hover:bg-green-700 text-xs shadow"
        target="_blank" title="Descargar PDF">
        PDF
    </a>

    <a href="{{ route('partes.duplicar', $parte->id) }}"
        class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs shadow"
        title="Duplicar registro">
        Duplicar
    </a>

    <a href="{{ route('partes.edit', $parte->id) }}"
        class="inline-flex items-center gap-1 px-2 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-xs shadow">
        Editar
    </a>

    <form action="{{ route('partes.destroy', $parte->id) }}" method="POST"
        class="inline-flex" onsubmit="return confirm('¿Eliminar este registro?')">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700 text-xs shadow">
            Eliminar
        </button>
    </form>
</td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="19" class="text-center px-4 py-6 text-gray-500">No hay registros disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 flex justify-center">
        {{ $partes->links() }}
    </div>
</div>
@endsection
