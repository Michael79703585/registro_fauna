@extends('layouts.app')

@section('title', 'Transferencias')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">📦 TRANSFERENCIAS DE FAUNA SILVESTRE</h1>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('transferencias.create') }}"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition text-sm font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Nueva
            </a>

            <a href="{{ route('transferencias.reportePdf') }}"
               style="background-color:#e54646; color:white; padding: 8px 16px; border-radius: 8px; text-decoration:none; display:inline-flex; align-items:center;">
                <i class="fas fa-file-pdf mr-2"></i> Reporte PDF
            </a>

            <a href="{{ route('transferencias.reporteExcel') }}"
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition text-sm font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 4h16v16H4V4z M4 8h16" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Excel
            </a>
        </div>
    </div>

    {{-- Filtro --}}
    <form method="GET" action="{{ route('transferencias.index') }}"
          class="mb-6 bg-white border border-gray-200 p-6 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="relative">
                <input type="text" name="codigo" value="{{ request('codigo') }}" placeholder="Código"
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-barcode"></i>
                </span>
            </div>

            <div class="relative">
                <input type="date" name="fecha_transferencia" value="{{ request('fecha_transferencia') }}"
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-calendar-alt"></i>
                </span>
            </div>

            <div class="relative">
                <input type="text" name="destino" value="{{ request('destino') }}" placeholder="Institución Destino"
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-map-pin"></i>
                </span>
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <button type="submit"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium shadow-sm">
                <i class="fas fa-search mr-2"></i> Buscar
            </button>
            <a href="{{ route('transferencias.index') }}"
               class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium shadow-sm">
                <i class="fas fa-times mr-2"></i> Limpiar
            </a>
        </div>
    </form>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 text-green-800 border border-green-300 p-4 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-6 py-4">Código</th>
                    <th class="px-6 py-4">Tipo Animal</th>
                    <th class="px-6 py-4">Especie</th>
                    <th class="px-6 py-4">Origen</th>
                    <th class="px-6 py-4">Destino</th>
                    <th class="px-6 py-4">Fecha</th>
                    <th class="px-6 py-4">Motivo</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transferencias as $transferencia)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $transferencia->fauna->codigo }}</td>
                        <td class="px-6 py-4">{{ $transferencia->fauna->tipo_animal ?? 'No definido' }}</td>
                        <td class="px-6 py-4">{{ $transferencia->fauna->especie }}</td>
                        <td class="px-6 py-4">{{ $transferencia->institucionOrigen->nombre ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $transferencia->institucionDestino->nombre ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $transferencia->fecha_transferencia ?? 'No definida' }}</td>
                        <td class="px-6 py-4">{{ $transferencia->motivo }}</td>
                        <td class="px-6 py-4">
                            @php
                                $estadoColor = match($transferencia->estado) {
                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                    'aceptado' => 'bg-green-100 text-green-800',
                                    'rechazado' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $estadoColor }}">
                                {{ ucfirst($transferencia->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-2">
                                {{-- Ver --}}
                                <a href="{{ route('transferencias.show', $transferencia->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs font-semibold shadow transition">
                                    <i class="fas fa-eye"></i> Ver
                                </a>

                                {{-- Editar --}}
                                <a href="{{ route('transferencias.edit', $transferencia->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-xs font-semibold shadow transition">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                {{-- Eliminar --}}
                                @if($transferencia->estado === 'pendiente')
                                    <form action="{{ route('transferencias.destroy', $transferencia->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar transferencia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700 text-xs font-semibold shadow transition">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                @endif

                                {{-- PDF --}}
                                @php
                                    $userInstitucionId = (int) Auth::user()->institucion_id;
                                    $institucionOrigenId = (int) $transferencia->institucion_origen;
                                @endphp
                                @if ($userInstitucionId === $institucionOrigenId)
                                    <a href="{{ route('transferencias.pdf', $transferencia->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-600 text-white hover:bg-green-700 text-xs font-semibold shadow transition">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                @endif

                                {{-- Aceptar / Rechazar --}}
                                @if($userInstitucionId === (int) $transferencia->institucion_destino && $transferencia->estado === 'pendiente')
                                    <form action="{{ route('transferencias.changeStatus', $transferencia->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="estado" value="aceptado">
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-500 text-white hover:bg-green-600 text-xs font-semibold shadow transition">
                                            <i class="fas fa-check"></i> Aceptar
                                        </button>
                                    </form>
                                    <form action="{{ route('transferencias.changeStatus', $transferencia->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="estado" value="rechazado">
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-500 text-white hover:bg-red-600 text-xs font-semibold shadow transition">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No hay transferencias registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection