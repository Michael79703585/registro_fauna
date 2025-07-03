@extends('layouts.app')

@section('title', 'Editar Evento de Nacimiento')

@section('content')
<style>
    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 700px;
        margin: 3rem auto;
        background: #fff;
        padding: 2.5rem 2rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease;
    }
    .container:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    h1 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 1.5rem;
        color: #0b0553; /* azul bootstrap para diferencia */
        border-bottom: 3px solid #0d6efd;
        padding-bottom: 0.3rem;
        user-select: none;
    }

    label.form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.4rem;
        display: block;
    }

    input.form-control,
    select.form-select,
    textarea.form-control {
        width: 100%;
        padding: 0.55rem 1rem;
        font-size: 1rem;
        border-radius: 12px;
        border: 1.5px solid #061423;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        resize: vertical;
        font-family: inherit;
    }

    input.form-control:focus,
    select.form-select:focus,
    textarea.form-control:focus {
        border-color: #020a17;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        outline: none;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    /* Botones */
    .btn-group {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1.75rem;
    }
    .btn-primary {
        background: linear-gradient(135deg, #020d1d, #0a58ca);
        border: none;
        color: #ffffff;
        font-weight: 600;
        padding: 0.65rem 1.75rem;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(7, 30, 63, 0.4);
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #000000, #084298);
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.7);
    }
    .btn-secondary {
        border-radius: 12px;
        padding: 0.65rem 1.75rem;
        font-weight: 600;
        color: #fff;
        background-color: #6c757d;
        border: none;
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        box-shadow: 0 8px 25px rgba(90, 98, 104, 0.7);
    }

    /* Imagen previa */
    .foto-previa {
        display: block;
        margin-bottom: 1rem;
        border-radius: 12px;
        max-width: 150px;
        height: auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Responsive textarea */
    textarea {
        min-height: 100px;
    }
</style>

<div class="container" role="main" aria-labelledby="edit-nacimiento-title">
    <h1 id="edit-nacimiento-title">Editar Nacimiento</h1>

    <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <input type="hidden" name="tipo_evento_id" value="{{ $evento->tipo_evento_id }}">

        <div class="mb-4">
            <label for="fecha" class="form-label">Fecha</label>
            <input
                type="date"
                name="fecha"
                id="fecha"
                class="form-control @error('fecha') is-invalid @enderror"
                value="{{ old('fecha', $evento->fecha->format('Y-m-d')) }}"
                required
                aria-describedby="fechaHelp"
            >
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="especie" class="form-label">Especie</label>
            <input
                type="text"
                name="especie"
                id="especie"
                class="form-control @error('especie') is-invalid @enderror"
                value="{{ old('especie', $evento->especie) }}"
                required
                aria-describedby="especieHelp"
            >
            @error('especie')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="nombre_comun" class="form-label">Nombre Común</label>
            <input
                type="text"
                name="nombre_comun"
                id="nombre_comun"
                class="form-control @error('nombre_comun') is-invalid @enderror"
                value="{{ old('nombre_comun', $evento->nombre_comun) }}"
                aria-describedby="nombreComunHelp"
            >
            @error('nombre_comun')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="sexo" class="form-label">Sexo</label>
            <select
                name="sexo"
                id="sexo"
                class="form-select @error('sexo') is-invalid @enderror"
                aria-describedby="sexoHelp"
            >
                <option value="">Seleccione</option>
                <option value="Macho" {{ old('sexo', $evento->sexo) == 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ old('sexo', $evento->sexo) == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                <option value="Desconocido" {{ old('sexo', $evento->sexo) == 'Desconocido' ? 'selected' : '' }}>Desconocido</option>
            </select>
            @error('sexo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="senas_particulares" class="form-label">Señas Particulares</label>
            <textarea
                name="senas_particulares"
                id="senas_particulares"
                class="form-control @error('senas_particulares') is-invalid @enderror"
                aria-describedby="senasHelp"
            >{{ old('senas_particulares', $evento->senas_particulares) }}</textarea>
            @error('senas_particulares')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="codigo_padres" class="form-label">Código de Padres</label>
            <input
                type="text"
                name="codigo_padres"
                id="codigo_padres"
                class="form-control @error('codigo_padres') is-invalid @enderror"
                value="{{ old('codigo_padres', $evento->codigo_padres) }}"
                aria-describedby="codigoPadresHelp"
            >
            @error('codigo_padres')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="categoria" class="form-label">Categoría</label>
            <select
                name="categoria"
                id="categoria"
                class="form-select @error('categoria') is-invalid @enderror"
                aria-describedby="categoriaHelp"
            >
                <option value="">Seleccione</option>
                <option value="mamifero" {{ old('categoria', $evento->categoria) == 'mamifero' ? 'selected' : '' }}>Mamífero</option>
                <option value="ave" {{ old('categoria', $evento->categoria) == 'ave' ? 'selected' : '' }}>Ave</option>
                <option value="reptil" {{ old('categoria', $evento->categoria) == 'reptil' ? 'selected' : '' }}>Reptil</option>
                <option value="anfibio" {{ old('categoria', $evento->categoria) == 'anfibio' ? 'selected' : '' }}>Anfibio</option>
                <option value="otro" {{ old('categoria', $evento->categoria) == 'otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('categoria')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea
                name="observaciones"
                id="observaciones"
                class="form-control @error('observaciones') is-invalid @enderror"
                aria-describedby="observacionesHelp"
            >{{ old('observaciones', $evento->observaciones) }}</textarea>
            @error('observaciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="foto" class="form-label">Foto actual</label><br>
            @if($evento->foto)
                <img src="{{ asset('storage/eventos/' . $evento->foto) }}" alt="Foto Evento" class="foto-previa">
            @else
                <p>No hay foto</p>
            @endif
            <input
                type="file"
                name="foto"
                id="foto"
                class="form-control @error('foto') is-invalid @enderror"
                accept=".jpg,.jpeg,.png"
                aria-describedby="fotoHelp"
            >
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="btn-group">
            <a href="{{ route('eventos.index') }}" class="btn btn-secondary" role="button" aria-label="Cancelar y volver al listado de eventos">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary" aria-label="Guardar cambios del evento de nacimiento">
                Actualizar Nacimiento
            </button>
        </div>
    </form>
</div>
@endsection
