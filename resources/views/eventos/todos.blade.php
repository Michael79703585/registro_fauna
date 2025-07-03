@extends('layouts.app')

@section('title', 'Todos los Eventos')

@section('content')
<style>
    .btn-action {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.03em;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-view { background-color: #3498db; color: white; }
    .btn-view:hover { background-color: #2980b9; box-shadow: 0 6px 12px rgba(41, 128, 185, 0.3); }

    .btn-edit { background-color: #f1c40f; color: #2c3e50; }
    .btn-edit:hover { background-color: #d4ac0d; box-shadow: 0 6px 12px rgba(212, 172, 13, 0.3); }

    .btn-delete { background-color: #e74c3c; color: white; }
    .btn-delete:hover { background-color: #c0392b; box-shadow: 0 6px 12px rgba(192, 57, 43, 0.3); }

    .btn-pdf { background-color: #8e44ad; color: white; }
    .btn-pdf:hover { background-color: #732d91; box-shadow: 0 6px 12px rgba(115, 45, 145, 0.3); }

    .btn-back, .btn-export {
        padding: 0.6rem 1.5rem;
        font-weight: 700;
        border-radius: 0.6rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-back {
        background: linear-gradient(to right, #5dade2, #3498db);
        color: white;
    }

    .btn-back:hover {
        background: linear-gradient(to right, #2980b9, #2471a3);
    }

    .btn-export {
        background: linear-gradient(to right, #2ecc71, #27ae60);
        color: white;
    }

    .btn-export:hover {
        background: linear-gradient(to right, #229954, #1e8449);
    }
</style>

<div class="w-full min-h-screen bg-white py-10 px-6">
    <div class="max-w-7xl mx-auto shadow rounded-lg bg-white">
        <h2 class="text-2xl font-bold mb-6">📋 TODOS LOS EVENTOS REGISTRADOS</h2>

         <!-- Filtros -->
        <form method="GET" action="{{ route('eventos.todos') }}" class="mb-6 flex flex-wrap items-end gap-4">
            <div>
                <label for="tipo" class="block font-semibold">Tipo de Evento</label>
                <select name="tipo" id="tipo" class="border rounded px-3 py-2">
                    <option value="">Todos</option>
                    @foreach($tiposEvento as $tipo)
                        <option value="{{ $tipo->nombre }}" {{ request('tipo') == $tipo->nombre ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>


        <div>
                <label for="codigo" class="block font-semibold">Código Animal</label>
                <input type="text" name="codigo" id="codigo" value="{{ request('codigo') }}" placeholder="Ej: GAC-NAC-0001" class="border rounded px-3 py-2">
            </div>

            <button type="submit" class="btn-export">🔍 Filtrar</button>
            <a href="{{ route('eventos.todos') }}" class="btn-back">↻ Limpiar</a>
            <a href="{{ route('eventos.exportar_excel') }}" class="btn-export">📊 Exportar Tabla a Excel</a>
            <a href="{{ route('eventos.pdf') }}" class="btn-export">📄 Exportar PDF</a>
        </form>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto max-h-[75vh] border border-gray-300 rounded">
            <table class="w-full table-auto border-collapse text-sm">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="text-center">
                        <th class="border px-2 py-2">#</th>
                        <th class="border px-2 py-2">Tipo Evento</th>
                        <th class="border px-2 py-2">Código Animal</th>
                        <th class="border px-2 py-2">Especie</th>
                        <th class="border px-2 py-2">Nombre Común</th>
                        <th class="border px-2 py-2">Sexo</th>
                        <th class="border px-2 py-2">Fecha</th>
                        <th class="border px-2 py-2">Institución</th>
                        <th class="border px-2 py-2 text-left">Motivo / Observaciones</th>
                        <th class="border px-2 py-2">Foto</th>
                        <th class="border px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eventos as $evento)
                        <tr class="text-center even:bg-gray-50">
                            <td class="border px-2 py-2">{{ $eventos->firstItem() + $loop->index }}</td>
                            <td class="border px-2 py-2">{{ optional($evento->tipoEvento)->nombre ?? '-' }}</td>
                            <td class="border px-2 py-2">{{ $evento->codigo ?? '-' }}</td>
                            <td class="border px-2 py-2">{{ $evento->especie ?? '-' }}</td>
                            <td class="border px-2 py-2">{{ $evento->nombre_comun ?? '-' }}</td>
                            <td class="border px-2 py-2">{{ $evento->sexo ?? '-' }}</td>
                            <td class="border px-2 py-2">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</td>
                            <td class="border px-2 py-2">{{ optional($evento->institucion)->nombre ?? '-' }}</td>
                            <td class="border px-2 py-2 text-left max-w-xs break-words">
                                <p><strong>Motivo:</strong> {{ $evento->motivo ?? '-' }}</p>
                                <p><strong>Observaciones:</strong> {{ $evento->observaciones ?? '-' }}</p>
                            </td>
                            <td class="border px-2 py-2">
                                @if($evento->foto && file_exists(public_path("storage/{$evento->foto}")))
                                    <a href="{{ asset('storage/' . $evento->foto) }}" target="_blank" title="Ver foto">
                                        <img src="{{ asset('storage/' . $evento->foto) }}" alt="Foto" class="h-16 w-16 object-cover rounded mx-auto shadow">
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Sin foto</span>
                                @endif
                            </td>
                            <td class="border px-2 py-2 space-y-1">
                                <a href="{{ route('eventos.exportar_pdf_individual', $evento->id) }}" class="btn-action btn-pdf block">PDF</a>
                                <a href="{{ route('eventos.show', $evento->id) }}" class="btn-action btn-view block">Ver</a>
                                <a href="{{ route('eventos.edit', $evento->id) }}" class="btn-action btn-edit block">Editar</a>
                                <form action="{{ route('eventos.destroy', $evento->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este evento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete w-full">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-gray-500 py-6">No hay eventos registrados.</td>
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
