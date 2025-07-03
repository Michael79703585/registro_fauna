@extends('layouts.app')

@section('title', 'Historiales Clínicos')
@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-2xl shadow-xl">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-6">
  <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 flex items-center gap-3">
    <span class="text-indigo-600 text-4xl">🩺</span>
    HISTORIALES CLÍNICOS
  </h1>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('historial.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo
            </a>

            <a href="{{ route('historial.reportePdf', ['buscar' => request('buscar')]) }}" target="_blank"
               class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 2h9a4 4 0 014 4v12a4 4 0 01-4 4H6a4 4 0 01-4-4V6a4 4 0 014-4zM6 6v12h9a2 2 0 002-2V6a2 2 0 00-2-2H6z" />
                </svg>
                Exportar PDF 
            </a>

            <a href="{{ route('historial.reporteExcel', ['buscar' => request('buscar')]) }}" target="_blank"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM7 17H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V7h2v2zm10 8h-6v-2h6v2zm0-4h-6v-2h6v2zm0-4h-6V7h6v2z" />
                </svg>
                Excel Filtrado
            </a>
        </div>
    </div>

    {{-- Búsqueda --}}
    <form method="GET" class="mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <input type="text" name="buscar" placeholder="Buscar por código o nombre común"
                   value="{{ request('buscar') }}"
                   class="w-full sm:w-1/2 border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition">
                Buscar
            </button>
        </div>
    </form>

    {{-- Tabla --}}

<div class="w-full overflow-x-auto rounded-lg shadow ring-1 ring-gray-300">
    <table class="w-full min-w-[1200px] bg-white text-sm text-gray-700 border border-gray-200">
        <thead class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wide">
            <tr>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Código</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Fecha de Recepción</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Departamento</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Ciudad</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Tipo de Animal</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Nombre Común</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Especie</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Edad Aparente</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Sexo</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Comportamiento</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Otras Observaciones</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Fecha (Historial)</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Diagnóstico</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Tratamiento</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Evolución</th>
                <th class="px-4 py-3 sticky top-0 bg-gray-100 z-10">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            
            @forelse ($historiales as $historial)
    @php
    $fueTransferida = $historial->fauna->ultimaTransferencia !== null;
@endphp

<tr class="hover:bg-gray-50 transition {{ $fueTransferida ? 'bg-green-100 text-green-800 font-medium' : '' }}">
        <td class="px-4 py-3 font-mono text-blue-900">{{ $historial->fauna->codigo }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->fecha_recepcion }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->departamento }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->ciudad }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->tipo_animal }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->nombre_comun }}</td>
        <td class="px-4 py-3 italic">{{ $historial->fauna->especie }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->edad_aparente }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->sexo }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->comportamiento }}</td>
        <td class="px-4 py-3">{{ $historial->fauna->otras_observaciones }}</td>
        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($historial->fecha)->format('Y-m-d') }}</td>
        <td class="px-4 py-3">{{ Str::limit($historial->diagnostico, 50) }}</td>
        <td class="px-4 py-3">{{ Str::limit($historial->tratamiento, 50) }}</td>
        <td class="px-4 py-3">{{ Str::limit($historial->observaciones, 50) }}</td>
        <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('historial.show', $historial->id) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition font-semibold text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver
                            </a>

                            <a href="{{ route('historial.edit', $historial->id) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded-md shadow hover:bg-green-700 transition font-semibold text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                </svg>
                                Editar
                            </a>

                            <a href="{{ route('historial.pdf', $historial->id) }}" 
                               target="_blank"
                               style="background-color:#6B4C3B !important; color: white !important;"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md shadow hover:bg-[#553B2D] transition font-semibold text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 2h9a4 4 0 014 4v12a4 4 0 01-4 4H6a4 4 0 01-4-4V6a4 4 0 014-4z"/>
                                    <path d="M10 9h4v2h-4zM10 13h4v2h-4z"/>
                                </svg>
                                PDF
                            </a>

                            <a href="{{ route('historial.duplicate', $historial->id) }}" 
                               title="Duplicar historial"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 transition font-semibold text-xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 17H6a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                                    <path d="M13 7h5a2 2 0 012 2v6a2 2 0 01-2 2h-1"/>
                                    <path d="M15 17v-4H9v4"/>
                                </svg>
                                Duplicar
                            </a>

                            <form action="{{ route('historial.destroy', $historial->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este historial?');" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded-md shadow hover:bg-red-700 transition font-semibold text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7L5 21M5 7l14 14"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" class="px-4 py-4 text-center text-gray-500">No hay historiales registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $historiales->links('pagination::tailwind') }}
    </div>

</div>
@endsection
