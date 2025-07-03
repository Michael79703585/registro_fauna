@extends('layouts.app')

@section('title', 'Editar Evento de Fuga')

@section('content')
<style>
    /* Fondo y fuente */
    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Contenedor central */
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

    /* Título */
    h1 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 1.5rem;
        color: #0a0649; /* Rojo Bootstrap */
        border-bottom: 3px solid #150834;
        padding-bottom: 0.3rem;
        user-select: none;
    }

    /* Labels */
    label.form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.4rem;
        display: block;
    }

    /* Inputs y Textareas */
    input.form-control,
    textarea.form-control {
        width: 100%;
        padding: 0.55rem 1rem;
        font-size: 1rem;
        border-radius: 12px;
        border: 1.5px solid #ced4da;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        resize: vertical;
        font-family: inherit;
    }
    input.form-control:focus,
    textarea.form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        outline: none;
    }

    /* Error styles */
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
    .btn-warning {
        background: linear-gradient(135deg, #f6c23e, #dda20a);
        border: none;
        color: #212529;
        font-weight: 600;
        padding: 0.65rem 1.75rem;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(221, 162, 10, 0.4);
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-warning:hover {
        background: linear-gradient(135deg, #dda20a, #b38600);
        box-shadow: 0 8px 25px rgba(221, 162, 10, 0.7);
        color: #111;
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

    /* Responsive textarea height */
    textarea {
        min-height: 100px;
    }
</style>

<div class="container" role="main" aria-labelledby="edit-fuga-title">
    <h1 id="edit-fuga-title">Editar Evento de Fuga</h1>

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
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea 
                name="descripcion" 
                id="descripcion" 
                class="form-control @error('descripcion') is-invalid @enderror" 
                required
                aria-describedby="descripcionHelp"
            >{{ old('descripcion', $evento->descripcion) }}</textarea>
            @error('descripcion')
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

        <div class="btn-group">
            <a href="{{ route('eventos.index') }}" class="btn btn-secondary" role="button" aria-label="Cancelar y volver al listado de eventos">
                Cancelar
            </a>
            <button type="submit" class="btn btn-warning" aria-label="Guardar cambios del evento de fuga">
                Actualizar Fuga
            </button>
        </div>
    </form>
</div>
@endsection
