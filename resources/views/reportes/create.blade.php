@extends('layouts.app')

@section('title', 'Crear Reporte')

@section('content')
<div class="container py-5">
    {{-- Encabezado --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold text-primary mb-3 mb-md-0">Previsualización de Reporte</h1>
        <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    {{-- Filtros --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">Filtrar Datos</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.create') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="">-- Todos --</option>
                        <option value="registro" {{ request('tipo') == 'registro' ? 'selected' : '' }}>Registro</option>
                        <option value="nacimiento" {{ request('tipo') == 'nacimiento' ? 'selected' : '' }}>Nacimiento</option>
                        <option value="deceso" {{ request('tipo') == 'deceso' ? 'selected' : '' }}>Deceso</option>
                        <option value="fuga" {{ request('tipo') == 'fuga' ? 'selected' : '' }}>Fuga</option>
                        <option value="transferido" {{ request('tipo') == 'transferido' ? 'selected' : '' }}>Transferido</option>
                        <option value="recepcion" {{ request('tipo') == 'recepcion' ? 'selected' : '' }}>Recepcion</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control">
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn-primary shadow-sm" type="submit"><i class="bi bi-filter"></i> Aplicar Filtros</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Información general --}}
    <x-reportes.informacion-general :tipo="$tipo" :institucion="$institucion" :fecha_inicio="$fecha_inicio" :fecha_fin="$fecha_fin" />

    {{-- Tabla de datos --}}
    <x-reportes.tabla-poblacion :datos="$datos_poblacion" />

    {{-- Lista detallada de fauna --}}
    @if(isset($faunas) && $faunas->count())
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white fw-bold">
                Faunas Registradas ({{ $faunas->count() }})
            </div>
            <div class="card-body table-responsive">
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
                                <td>{{ $fauna->fecha_recepcion ? $fauna->fecha_recepcion->format('d/m/Y') : '-' }}</td>
                                <td>{{ $fauna->estado ?? '-' }}</td>
                                <td class="text-start">{{ $fauna->comentarios ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Acciones --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <form action="{{ route('reportes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="datos_poblacion" value="{{ json_encode($datos_poblacion) }}">
            <input type="hidden" name="tipo" value="{{ $tipo }}">
            <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
            <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
            <input type="hidden" name="institucion_id" value="{{ $institucion->id ?? '' }}">

            <button type="submit" class="btn btn-primary shadow-sm">
                <i class="bi bi-save-fill"></i> Guardar Reporte
            </button>
        </form>

        <div class="d-flex gap-2">
            <a href="{{ route('reportes.exportPDF.preview') }}" class="btn btn-danger shadow-sm" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill"></i> Exportar PDF
            </a>
            <a href="{{ route('reportes.exportExcel.preview') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar Excel
            </a>
        </div>
    </div>
</div>

{{-- Estilos personalizados --}}
<style>
    dt { font-weight: 600; }
    dd { margin-bottom: 0.75rem; }
    .table tbody tr:hover {
        background-color: #f1f7ff;
        transition: background-color 0.3s ease;
    }
</style>
@endsection
