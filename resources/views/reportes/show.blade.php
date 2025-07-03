@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Título y botones --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold text-primary mb-3 mb-md-0">Reporte #{{ $reporte->id }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="{{ route('reportes.exportPDF', $reporte->id) }}" class="btn btn-danger shadow-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill"></i> Exportar PDF
            </a>
            <a href="{{ route('reportes.exportExcel', $reporte->id) }}" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar Excel
            </a>
        </div>
    </div>

    {{-- Datos generales --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            Información General
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Tipo</dt>
                <dd class="col-sm-9 text-capitalize">{{ $reporte->tipo }}</dd>

                <dt class="col-sm-3">Institución</dt>
                <dd class="col-sm-9">{{ $reporte->institucion->nombre ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Fecha Inicio</dt>
                <dd class="col-sm-9">{{ $reporte->fecha_inicio ?? '-' }}</dd>

                <dt class="col-sm-3">Fecha Fin</dt>
                <dd class="col-sm-9">{{ $reporte->fecha_fin ?? '-' }}</dd>
            </dl>
        </div>
    </div>

    {{-- Datos poblacionales --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-secondary text-white fw-bold">
            Datos Poblacionales Detallados
        </div>
        <div class="card-body">
            @php
                $datos = is_array($reporte->datos_poblacion)
                    ? $reporte->datos_poblacion
                    : json_decode($reporte->datos_poblacion, true) ?? [];
                $categorias = ['Registros', 'Nacimiento', 'Deceso', 'Fuga', 'Transferidos', 'Recepciones'];
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Fauna</th>
                            @foreach($categorias as $cat)
                                <th>{{ $cat }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $fauna => $valores)
                            @if(is_array($valores))
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
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary fw-bold">
                            <td>Total General</td>
                            @foreach($categorias as $cat)
                                <td>
                                    {{ collect($datos)->sum(function($item) use($cat) {
                                        return is_array($item) && isset($item[$cat]) ? intval($item[$cat]) : 0;
                                    }) }}
                                </td>
                            @endforeach
                            <td>
                                {{ collect($datos)->sum(function($item) use($categorias) {
                                    if(!is_array($item)) return 0;
                                    return array_sum(array_map('intval', array_intersect_key($item, array_flip($categorias))));
                                }) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Lista completa de fauna --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white fw-bold">
            Faunas Registradas ({{ $faunas->count() }})
        </div>
        <div class="card-body table-responsive">
            @if($faunas->count())
                <table class="table table-striped table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Común</th>
                            <th>Nombre Científico</th>
                            <th>Institución Remitente</th>
                            <th>Fecha Recepción</th>
                            <th>Estado</th>
                            <th>Comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faunas as $fauna)
                            <tr>
                                <td>{{ $fauna->id }}</td>
                                <td>{{ $fauna->nombre_comun ?? '-' }}</td>
                                <td><em>{{ $fauna->nombre_cientifico ?? '-' }}</em></td>
                                <td>{{ $fauna->institucion_remitente ?? '-' }}</td>
                                <td>{{ $fauna->fecha_recepcion ? \Carbon\Carbon::parse($fauna->fecha_recepcion)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $fauna->estado ?? '-' }}</td>
                                <td class="text-start">{{ $fauna->comentarios ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{-- Si usas paginación aquí --}}
                    {{-- {{ $faunas->links() }} --}}
                </div>
            @else
                <div class="alert alert-warning text-center mb-0">
                    No hay faunas registradas para este reporte.
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Puedes agregar estilos personalizados aquí o en tu CSS global --}}
<style>
    dt {
        font-weight: 600;
    }
    dd {
        margin-bottom: 0.75rem;
    }
    .table-responsive {
        max-height: 450px;
        overflow-y: auto;
    }
    .table tbody tr:hover {
        background-color: #f1f7ff;
        transition: background-color 0.3s ease;
    }
</style>

@endsection
