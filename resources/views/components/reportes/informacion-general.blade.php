<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-bold">
        Información General
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Tipo</dt>
            <dd class="col-sm-9 text-capitalize">{{ $tipo ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Institución</dt>
            <dd class="col-sm-9">{{ $institucion->nombre ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Fecha Inicio</dt>
            <dd class="col-sm-9">{{ $fecha_inicio ?? '-' }}</dd>

            <dt class="col-sm-3">Fecha Fin</dt>
            <dd class="col-sm-9">{{ $fecha_fin ?? '-' }}</dd>
        </dl>
    </div>
</div>
