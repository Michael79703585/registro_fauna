@extends('layouts.app')

@section('title', 'Decesos')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .form-container {
        max-width: 900px;
        margin: 3rem auto;
        padding: 2.5rem 3rem;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h1 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 2rem;
        letter-spacing: 0.04em;
    }
    label.form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 0.5rem;
    }
    input.form-control, select.form-select, textarea.form-control {
        border: 1.8px solid #ced4da;
        border-radius: 0.5rem;
        padding: 0.65rem 1rem;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }
    input.form-control:focus, select.form-select:focus, textarea.form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 8px rgba(78,115,223,0.5);
        outline: none;
    }
    .is-invalid {
        border-color: #e74c3c !important;
        box-shadow: 0 0 8px rgba(231,76,60,0.5) !important;
    }
    .invalid-feedback {
        font-size: 0.875rem;
        color: #e74c3c;
        margin-top: 0.25rem;
    }
    .row.g-4 > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    .btn-animated {
        position: relative;
        overflow: hidden;
        color: #fff;
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        padding: 0.75rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 0.75rem;
        box-shadow: 0 6px 12px rgba(78,115,223,0.4);
        transition: all 0.35s ease;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        z-index: 1;
    }
    .btn-animated::before {
        content: '';
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: rgba(255, 255, 255, 0.25);
        transform: skewX(-25deg);
        transition: left 0.5s ease;
        z-index: 0;
    }
    .btn-animated:hover {
        background: linear-gradient(45deg, #224abe, #4e73df);
        box-shadow: 0 8px 16px rgba(34,74,190,0.6);
        transform: translateY(-3px);
    }
    .btn-animated:hover::before {
        left: 125%;
    }
    .btn-cancel {
        background: #bdc3c7;
        color: #2c3e50;
        font-weight: 600;
        border-radius: 0.75rem;
        padding: 0.75rem 2rem;
        box-shadow: 0 4px 10px rgba(189,195,199,0.5);
        transition: background-color 0.3s ease, color 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .btn-cancel:hover {
        background: #95a5a6;
        color: #1f2d3d;
    }
    .btn-group {
        display: flex;
        gap: 1.5rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }
    @media (max-width: 576px) {
        .form-container {
            padding: 2rem 1.5rem;
        }
        .btn-group {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        .btn-animated, .btn-cancel {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="form-container shadow-sm">
    <h1>☠️ CREAR EVENTO DE DECESO</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups, ocurrió un error:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="tipo_evento_id" value="{{ $tiposEvento->firstWhere('nombre', 'Deceso')->id }}">

        <div class="row g-4">
            <!-- Código Animal -->
            <div class="col-md-4">
                <label for="codigo_animal" class="form-label">Código del Animal</label>
                <select name="codigo_animal" id="codigo_animal" class="form-control select2 @error('codigo_animal') is-invalid @enderror" required>
                    <option value="">Seleccione un animal</option>
                    @foreach ($animalesDisponibles as $animal)
                        <option value="{{ $animal['codigo'] }}" {{ old('codigo_animal') == $animal['codigo'] ? 'selected' : '' }}>
                            {{ $animal['codigo'] }} - {{ $animal['especie'] }}
                        </option>
                    @endforeach
                </select>
                @error('codigo_animal') <div class="invalid-feedback">{{ $message }}</div> @enderror

                <!-- Hidden inputs para especies y nombre común -->
                <input type="hidden" name="especie" id="especie_hidden" value="{{ old('especie') }}">
                <input type="hidden" name="nombre_comun" id="nombre_comun_hidden" value="{{ old('nombre_comun') }}">
            </div>

            <!-- Especie -->
            <div class="col-md-4">
                <label for="especie" class="form-label">Especie</label>
                <input type="text" name="especie" id="especie" class="form-control" style="font-style: italic;" value="{{ old('especie') }}" readonly>
                @error('especie') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Nombre Común -->
<div class="col-md-4">
    <label for="nombre_comun" class="form-label">Nombre Común</label>
    <input type="text" name="nombre_comun" id="nombre_comun" class="form-control" value="{{ old('nombre_comun') }}" readonly>
</div>

         <!-- Sexo -->
<div class="col-md-4">
    <label for="sexo_display" class="form-label">Sexo</label>
    <input type="text" id="sexo_display" class="form-control" readonly value="{{ old('sexo') }}">
    <input type="hidden" name="sexo" id="sexo_hidden" value="{{ old('sexo') }}">
</div>

            <!-- Fecha del Deceso -->
            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha del Deceso</label>
                <input type="date" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required>
                @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Causa de Muerte -->
            <div class="col-md-8">
                <label for="causas_deceso" class="form-label">Causa de Muerte</label>
                <textarea name="causas_deceso" id="causas_deceso" rows="3" class="form-control @error('causas_deceso') is-invalid @enderror" required>{{ old('causas_deceso') }}</textarea>
                @error('causas_deceso') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Foto -->
            <div class="col-md-4">
                <label for="foto" class="form-label">Foto (opcional)</label>
                <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" class="form-control @error('foto') is-invalid @enderror">
                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Observaciones -->
            <div class="col-12">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="4" class="form-control @error('observaciones') is-invalid @enderror">{{ old('observaciones') }}</textarea>
                @error('observaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Hidden codigo -->
            <input type="hidden" name="codigo" id="codigo" value="{{ old('codigo', '') }}">
        </div>

        <div class="btn-group">
            <a href="{{ route('eventos.index') }}" class="btn btn-cancel">Cancelar</a>
            <button type="submit" class="btn btn-animated">Guardar Deceso</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Inicializa Select2
    $('.select2').select2({
        placeholder: 'Seleccione un animal',
        allowClear: true,
        width: '100%'
    });

    const faunaSelect = document.getElementById('codigo_animal');
    const especieInput = document.getElementById('especie');
    const especieHidden = document.getElementById('especie_hidden');
    const nombreComunInput = document.getElementById('nombre_comun');
    const nombreComunHidden = document.getElementById('nombre_comun_hidden');
    const sexoDisplay = document.getElementById('sexo_display');
    const sexoHidden = document.getElementById('sexo_hidden');

    const faunas = @json($animalesDisponibles);

    function actualizarDatosAnimal(codigoAnimal) {
        const animal = faunas.find(a => a.codigo == codigoAnimal);

        if (animal) {
            especieInput.value = animal.especie || '';
            especieHidden.value = animal.especie || '';

            nombreComunInput.value = animal.nombre_comun || '';
            nombreComunHidden.value = animal.nombre_comun || '';

            sexoDisplay.value = animal.sexo || '';
            sexoHidden.value = animal.sexo || '';
        } else {
            especieInput.value = '';
            especieHidden.value = '';

            nombreComunInput.value = '';
            nombreComunHidden.value = '';

            sexoDisplay.value = '';
            sexoHidden.value = '';
        }
    }

    // Evento cambio Select2 (usando jQuery)
    $('#codigo_animal').on('change', function () {
        actualizarDatosAnimal(this.value);
    });

    // Si ya hay un código seleccionado (edición o recarga)
    if (faunaSelect.value) {
        actualizarDatosAnimal(faunaSelect.value);
    }
});

</script>

@endsection