@extends('layouts.app')

@section('title', 'Editar Evento de Deceso')

@section('content')
<style>
    body {
        background: #f8fafc;
        font-family: 'Segoe UI', sans-serif;
    }

    .card-glass {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        padding: 3rem;
        transition: all 0.3s ease;
    }

    .form-label {
        font-weight: 600;
        color: #343a40;
    }

    .form-control {
        border-radius: 0.75rem;
        border: 1px solid #ced4da;
        padding: 0.65rem 1rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.2);
    }

    .img-preview {
        border-radius: 12px;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        object-fit: cover;
    }

    .img-preview:hover {
        transform: scale(1.04);
    }

    .btn-animated {
        transition: all 0.3s ease;
        border-radius: 0.6rem;
        font-weight: 600;
        letter-spacing: 0.4px;
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, #e53935, #d32f2f);
        border: none;
        color: #fff;
    }

    .btn-danger-custom:hover {
        background: linear-gradient(135deg, #c62828, #b71c1c);
        box-shadow: 0 6px 18px rgba(220, 53, 69, 0.4);
    }

    .btn-secondary-custom {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary-custom:hover {
        background-color: #565e64;
        box-shadow: 0 6px 14px rgba(108, 117, 125, 0.3);
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: #2c2f36;
    }

    .section-subtitle {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<div class="container py-5">
    <div class="card-glass">
        {{-- Header con icono --}}
        <div class="mb-4 d-flex align-items-center justify-content-between flex-wrap border-bottom pb-3">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-danger bg-opacity-25 text-danger d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width: 60px; height: 60px;">
                    <i class="bi bi-heartbreak-fill fs-3"></i>
                </div>
                <div>
                    <h1 class="section-title mb-0">Editar Evento de Deceso</h1>
                    <p class="section-subtitle mb-0">Gestiona los datos del evento de manera precisa.</p>
                </div>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('eventos.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al listado
                </a>
            </div>
        </div>

        {{-- Formulario --}}
        <form action="{{ route('eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="tipo_evento_id" value="{{ $evento->tipo_evento_id }}">

            {{-- Fecha --}}
            <div class="mb-4">
                <label for="fecha" class="form-label">Fecha del Deceso</label>
                <input type="date" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $evento->fecha->format('Y-m-d')) }}" required>
                @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Causas --}}
            <div class="mb-4">
                <label for="causas_deceso" class="form-label">Causas del Deceso</label>
                <input type="text" name="causas_deceso" id="causas_deceso" class="form-control @error('causas_deceso') is-invalid @enderror" value="{{ old('causas_deceso', $evento->causas_deceso) }}" placeholder="Ej. Enfermedad, Accidente..." required>
                @error('causas_deceso') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            {{-- Observaciones --}}
            <div class="mb-4">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3" class="form-control @error('observaciones') is-invalid @enderror" placeholder="Notas adicionales...">{{ old('observaciones', $evento->observaciones) }}</textarea>
                @error('observaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Foto --}}
            <div class="mb-4">
                <label class="form-label">Foto del Evento</label><br>
                <img id="preview-image" src="{{ $evento->foto ? asset('storage/eventos/' . $evento->foto) : 'https://via.placeholder.com/180x120?text=Sin+Foto' }}" alt="Vista previa de la foto" class="img-preview mb-3" width="180" height="120">
                <input type="file" name="foto" id="foto" class="form-control mt-2 @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG. Máx: 2MB.</small>
                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Botones --}}
            <div class="d-flex justify-content-between pt-3">
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary-custom btn-animated px-4">
                    <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-danger-custom btn-animated px-4">
                    <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Vista previa dinámica de imagen --}}
<script>
    document.getElementById('foto').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
