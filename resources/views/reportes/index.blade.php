@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold text-primary mb-3 mb-md-0">Listado de Reportes</h1>
        <a href="{{ route('reportes.create') }}" class="btn btn-lg btn-gradient-primary shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Nuevo Reporte
        </a>
    </div>

    {{-- Panel de filtros colapsable con animación --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="cursor:pointer" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="true" aria-controls="filtrosCollapse">
            <h5 class="mb-0">Filtros de Búsqueda <i class="bi bi-funnel-fill ms-2"></i></h5>
            <i class="bi bi-chevron-down fs-4 transition-icon"></i>
        </div>

        <div class="collapse show" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('reportes.index') }}" class="row g-4 align-items-end">

                    <div class="col-md-4">
                        <label for="tipo" class="form-label fw-semibold text-secondary">Tipo de Reporte</label>
                        <select name="tipo" id="tipo" class="form-select form-select-lg shadow-sm">
                            <option value="">Todos</option>
                            <option value="general" {{ request('tipo') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="filtrado" {{ request('tipo') == 'filtrado' ? 'selected' : '' }}>Filtrado</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="institucion" class="form-label fw-semibold text-secondary">Institución</label>
                        <select name="institucion_id" id="institucion" class="form-select form-select-lg shadow-sm">
                            <option value="">Todas</option>
                            @foreach($instituciones as $institucion)
                                <option value="{{ $institucion->id }}" {{ request('institucion_id') == $institucion->id ? 'selected' : '' }}>
                                    {{ $institucion->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-lg btn-outline-primary fw-semibold shadow-sm animate-btn">
                            <i class="bi bi-search me-2"></i> Buscar Reportes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabla con fade-in --}}
    @if($reportes->count())
        <div class="card shadow border-0 animate-fade-in">
            <div class="card-body p-0 overflow-auto" style="scroll-behavior: smooth;">
                <table class="table table-hover align-middle text-center mb-0" style="min-width: 1000px;">
                    <thead class="bg-primary text-white text-uppercase fw-semibold">
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Institución</th>
                            <th>Faunas</th>
                            <th>Registros</th>
                            <th>Nacimiento</th>
                            <th>Deceso</th>
                            <th>Fuga</th>
                            <th>Transferidos</th>
                            <th>Recepciones</th>
                            <th>Total</th>
                            <th style="min-width: 140px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportes as $reporte)
                            @php
                                $datos = is_array($reporte->datos_poblacion)
                                    ? $reporte->datos_poblacion
                                    : json_decode($reporte->datos_poblacion, true) ?? [];

                                $categorias = ['Registros', 'Nacimiento', 'Deceso', 'Fuga', 'Transferidos', 'Recepciones'];
                                $sumas = [];
                                foreach ($categorias as $cat) {
                                    $sumas[$cat] = array_sum(array_map('intval', $datos[$cat] ?? []));
                                }
                                $total = array_sum($sumas);
                            @endphp
                            <tr class="table-row-animate">
                                <td class="fw-bold text-secondary">{{ $reporte->id }}</td>
                                <td>
                                    <span class="badge bg-{{ $reporte->tipo == 'general' ? 'info' : 'warning' }} text-dark text-uppercase px-3 py-2 shadow-sm transition-badge">
                                        {{ $reporte->tipo }}
                                    </span>
                                </td>
                                <td class="text-truncate" style="max-width: 130px;">
                                    {{ $reporte->institucion->nombre ?? 'N/A' }}
                                </td>
                                <td><span class="badge bg-primary shadow transition-badge">{{ $reporte->faunas->count() }}</span></td>

                                @foreach($categorias as $cat)
                                    <td><span class="badge bg-light text-dark shadow-sm transition-badge">{{ $sumas[$cat] }}</span></td>
                                @endforeach

                                <td class="fw-bold text-success fs-5">{{ $total }}</td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('reportes.show', $reporte->id) }}" class="btn btn-sm btn-outline-info animate-btn" title="Ver Reporte">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('reportes.exportPDF', $reporte->id) }}" class="btn btn-sm btn-outline-danger animate-btn" title="Exportar PDF">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </a>
                                        <a href="{{ route('reportes.exportExcel', $reporte->id) }}" class="btn btn-sm btn-outline-success animate-btn" title="Exportar Excel">
                                            <i class="bi bi-file-earmark-excel-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-center bg-white border-0">
                {{ $reportes->withQueryString()->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center fs-5 shadow-sm animate-fade-in">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> No se encontraron reportes con los filtros aplicados.
        </div>
    @endif

</div>

{{-- Styles personalizados para degradados, sombras y animaciones --}}
<style>
    .btn-gradient-primary {
        background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
        color: white;
        transition: background 0.3s ease-in-out, transform 0.3s ease;
    }
    .btn-gradient-primary:hover {
        background: linear-gradient(90deg, #224abe 0%, #4e73df 100%);
        color: white;
        transform: scale(1.05);
    }

    /* Animación del icono flecha colapsable */
    .card-header[data-bs-toggle="collapse"] .transition-icon {
        transition: transform 0.4s ease;
    }
    .card-header.collapsed .transition-icon {
        transform: rotate(-180deg);
    }

    /* Fade in general para tarjetas y alertas */
    .animate-fade-in {
        animation: fadeIn 0.8s ease forwards;
        opacity: 0;
    }
    @keyframes fadeIn {
        to { opacity: 1; }
    }

    /* Hover filas tabla */
    .table-hover tbody tr:hover {
        background-color: #e9f1ff;
        transition: background-color 0.3s ease;
    }

    /* Animación badges al pasar el mouse */
    .transition-badge {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-badge:hover {
        transform: scale(1.15);
        box-shadow: 0 0 8px rgba(0,123,255,0.6);
        cursor: default;
    }

    /* Animación suave botones */
    .animate-btn {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .animate-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(0,123,255,0.5);
    }

    /* Animación filas al cargar (opcional) */
    .table-row-animate {
        animation: rowFadeIn 0.5s ease forwards;
        opacity: 0;
    }
    .table-row-animate:nth-child(even) {
        animation-delay: 0.15s;
    }
    .table-row-animate:nth-child(odd) {
        animation-delay: 0.3s;
    }
    @keyframes rowFadeIn {
        to { opacity: 1; }
    }
</style>

{{-- Script para animar icono del colapsable --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const collapseToggle = document.querySelector('.card-header[data-bs-toggle="collapse"]');
        const icon = collapseToggle.querySelector('.transition-icon');

        const collapseElement = document.getElementById('filtrosCollapse');
        collapseElement.addEventListener('show.bs.collapse', () => {
            icon.style.transform = 'rotate(0deg)';
        });
        collapseElement.addEventListener('hide.bs.collapse', () => {
            icon.style.transform = 'rotate(-180deg)';
        });
    });
</script>

@endsection
