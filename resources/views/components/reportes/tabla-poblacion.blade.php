@php
    $categorias = ['Registros', 'Nacimiento', 'Deceso', 'Fuga', 'Transferidos', 'Recepciones'];
    $faunas_disponibles = array_keys($datos_poblacion ?? []);
@endphp

<div class="card shadow-sm mb-5">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold">Datos Poblacionales Detallados</span>
        @if(count($faunas_disponibles))
        <form method="GET" class="d-flex gap-2 align-items-center">
            <label for="filtro_fauna" class="text-white mb-0">Filtrar por fauna:</label>
            <select name="filtro_fauna" id="filtro_fauna" class="form-select form-select-sm w-auto"
                onchange="this.form.submit()">
                <option value="">Todas</option>
                @foreach($faunas_disponibles as $nombre_fauna)
                    <option value="{{ $nombre_fauna }}" {{ request('filtro_fauna') == $nombre_fauna ? 'selected' : '' }}>
                        {{ $nombre_fauna }}
                    </option>
                @endforeach
            </select>
        </form>
        @endif
    </div>

    <div class="card-body">
        @php
            $filtrados = $datos_poblacion ?? [];

            if (request('filtro_fauna')) {
                $fauna_filtrada = request('filtro_fauna');
                $filtrados = isset($filtrados[$fauna_filtrada]) ? [$fauna_filtrada => $filtrados[$fauna_filtrada]] : [];
            }
        @endphp

        @if(empty($filtrados))
            <div class="alert alert-warning">No hay datos disponibles para mostrar.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-start">Fauna</th>
                            @foreach($categorias as $cat)
                                <th>{{ $cat }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filtrados as $fauna => $valores)
                            @php
                                $total = array_sum(array_map('intval', $valores));
                            @endphp
                            <tr>
                                <td class="text-start fw-semibold">{{ $fauna }}</td>
                                @foreach($categorias as $cat)
                                    <td>{{ $valores[$cat] ?? 0 }}</td>
                                @endforeach
                                <td class="fw-bold text-success">{{ $total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary fw-bold">
                            <td>Total General</td>
                            @foreach($categorias as $cat)
                                <td>
                                    {{ collect($filtrados)->sum(fn($item) => intval($item[$cat] ?? 0)) }}
                                </td>
                            @endforeach
                            <td>
                                {{ collect($filtrados)->sum(fn($item) => array_sum(array_map('intval', array_intersect_key($item, array_flip($categorias))))) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
