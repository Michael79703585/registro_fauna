@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perfil de Usuario: {{ $usuario->name }}</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Institución:</strong> {{ $usuario->institucion_id ?? 'N/A' }}</p>
        </div>
    </div>

    <h4>🦎 Registros de Fauna</h4>
<table class="table table-bordered mb-4" id="tabla-fauna">
    <thead>
        <tr>
             <th>Código</th>
            <th>Especie</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        {{-- Se llenará con JS --}}
    </tbody>
</table>


    {{-- Historial Clínico asociado a la fauna del usuario --}}
    <h4>📝 Historial Clínico</h4>
<table class="table table-bordered" id="tabla-historial">
    <thead>
        <tr>
             <th>Código</th>
            <th>Fauna</th>
            <th>Diagnóstico</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        {{-- Se llenará con JS --}}
    </tbody>
</table>


    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">← Volver</a>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const usuarioId = {{ $usuario->id }};

    function cargarFauna() {
    $.get(`/usuarios/${usuarioId}/fauna`, function(data) {
        let rows = '';
        if (data.length === 0) {
            rows = '<tr><td colspan="3">No hay registros de fauna para este usuario.</td></tr>';
        } else {
            data.forEach(fauna => {
                rows += `<tr>
    <td>${fauna.codigo}</td>
    <td><i>${fauna.especie}</i></td>
    <td>${new Date(fauna.created_at).toLocaleDateString()}</td>
</tr>`;
            });
        }
        $('#tabla-fauna tbody').html(rows);
    });
}

function cargarHistorial() {
    $.get(`/usuarios/${usuarioId}/historiales`, function(data) {
        let rows = '';
        if (data.length === 0) {
            rows = '<tr><td colspan="4">No hay historiales clínicos para este usuario.</td></tr>';
        } else {
            data.forEach(historial => {
                const especie = historial.fauna?.especie ?? 'Desconocido';
                rows += `<tr>
    <td>${fauna.codigo}</td>
    <td><i>${fauna.especie}</i></td>
    <td>${new Date(fauna.created_at).toLocaleDateString()}</td>
</tr>`;
            });
        }
        $('#tabla-historial tbody').html(rows);
    });
}

    // Cargar al iniciar y cada 10 segundos
    cargarFauna();
    cargarHistorial();
    setInterval(() => {
        cargarFauna();
        cargarHistorial();
    }, 10000);
</script>
@endpush
