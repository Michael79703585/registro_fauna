@extends('layouts.app')

@section('title', 'Nacimientos')

@section('content')
<style>
    /* Contenedor centrado con sombra sutil y bordes redondeados */
    .form-container {
        max-width: 900px;
        margin: 3rem auto;
        padding: 2.5rem 3rem;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Títulos */
    h1 {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 2rem;
        letter-spacing: 0.04em;
    }

    /* Labels destacados */
    label.form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 0.5rem;
    }

    /* Inputs y selects con sombra interior y transición suave */
    input.form-control, select.form-select, textarea.form-control {
        border: 1.8px solid #ced4da;
        border-radius: 0.5rem;
        padding: 0.65rem 1rem;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }

    /* Focus */
    input.form-control:focus, select.form-select:focus, textarea.form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 8px rgba(78,115,223,0.5);
        outline: none;
    }

    /* Validación errores */
    .is-invalid {
        border-color: #e74c3c !important;
        box-shadow: 0 0 8px rgba(231,76,60,0.5) !important;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #e74c3c;
        margin-top: 0.25rem;
    }

    /* Campos agrupados en grid */
    .row.g-4 > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }

    /* Textareas con altura mínima */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Botones con animación y efecto hover */
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
        user-select: none;
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

    /* Botón cancelar estilizado */
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

    /* Espaciado de botones */
    .btn-group {
        display: flex;
        gap: 1.5rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    /* Previsualización imagen */
    #preview-img {
        margin-top: 0.75rem;
        max-width: 200px;
        max-height: 200px;
        border-radius: 0.5rem;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Responsive para pantallas pequeñas */
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
    <h1> 🐣 CREAR EVENTO DE NACIMIENTO</h1>

    <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="tipo_evento_id" value="{{ $tiposEvento->firstWhere('nombre', 'Nacimiento')->id }}">

        <div class="row g-4">

            <!-- NUEVO CAMPO para mostrar el código generado -->
            <div class="col-md-4">
    <label for="codigo" class="form-label">Código del Evento</label>
    <input type="text" id="codigo" name="codigo" class="form-control" value="{{ old('codigo', $codigoNuevo) }}" readonly>
</div>


            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                <input type="date" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}" required autofocus aria-describedby="fecha-error">
                @error('fecha')
                    <div id="fecha-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="especie" class="form-label">Especie <span class="text-danger">*</span></label>
                <input type="text" name="especie" id="especie" class="form-control @error('especie') is-invalid @enderror" value="{{ old('especie') }}" placeholder="Ej: Panthera onca (Nombre científico)" required style="font-style: italic;" aria-describedby="especie-error">
                @error('especie')
                    <div id="especie-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="nombre_comun" class="form-label">Nombre Común</label>
                <input type="text" name="nombre_comun" id="nombre_comun" class="form-control @error('nombre_comun') is-invalid @enderror" value="{{ old('nombre_comun') }}" placeholder="Ej: Jaguar" aria-describedby="nombre_comun-error">
                @error('nombre_comun')
                    <div id="nombre_comun-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" id="sexo" class="form-select @error('sexo') is-invalid @enderror" aria-describedby="sexo-error">
                    <option value="" disabled {{ old('sexo') ? '' : 'selected' }}>Seleccione...</option>
                    <option value="Macho" {{ old('sexo') == 'Macho' ? 'selected' : '' }}>Macho</option>
                    <option value="Hembra" {{ old('sexo') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    <option value="Indeterminado" {{ old('sexo') == 'Indeterminado' ? 'selected' : '' }}>Indeterminado</option>
                </select>
                @error('sexo')
                    <div id="sexo-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label for="senas_particulares" class="form-label">Señas Particulares</label>
                <textarea name="senas_particulares" id="senas_particulares" rows="3" class="form-control @error('senas_particulares') is-invalid @enderror" placeholder="Descripción detallada..." aria-describedby="senas_particulares-error">{{ old('senas_particulares') }}</textarea>
                @error('senas_particulares')
                    <div id="senas_particulares-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="codigo_padres" class="form-label">Código de Padres</label>
                <input type="text" name="codigo_padres" id="codigo_padres" class="form-control @error('codigo_padres') is-invalid @enderror" value="{{ old('codigo_padres') }}" placeholder="Ej: PAD1234" aria-describedby="codigo_padres-error">
                @error('codigo_padres')
                    <div id="codigo_padres-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" aria-describedby="categoria-error">
                    <option value="" disabled {{ old('categoria') ? '' : 'selected' }}>Seleccione...</option>
                    <option value="mamifero" {{ old('categoria') == 'mamifero' ? 'selected' : '' }}>Mamífero</option>
                    <option value="ave" {{ old('categoria') == 'ave' ? 'selected' : '' }}>Ave</option>
                    <option value="reptil" {{ old('categoria') == 'reptil' ? 'selected' : '' }}>Reptil</option>
                    <option value="anfibio" {{ old('categoria') == 'anfibio' ? 'selected' : '' }}>Anfibio</option>
                    <option value="otro" {{ old('categoria') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('categoria')
                    <div id="categoria-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="foto" class="form-label">Foto (jpg, jpeg, png)</label>
                <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" class="form-control @error('foto') is-invalid @enderror" aria-describedby="foto-error">
                @error('foto')
                    <div id="foto-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
                <img id="preview-img" src="#" alt="Previsualización de la imagen" style="display:none;">
            </div>

            <div class="col-12">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="4" class="form-control @error('observaciones') is-invalid @enderror" placeholder="Información adicional..." aria-describedby="observaciones-error">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <div id="observaciones-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('eventos.index') }}" class="btn btn-cancel">Cancelar</a>
            <button type="submit" class="btn btn-animated">Guardar Nacimiento</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('preview-img');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });

      // --- Código para generar el código de nacimiento ---
    window.addEventListener('DOMContentLoaded', () => {
        // Aquí recibimos la sigla de la institución desde blade (que el backend debe enviar)
        const siglaInstitucion = @json($siglaInstitucion ?? 'GADC'); // valor por defecto GADC

        // Función para formatear el número con ceros a la izquierda (ej: 1 -> 0001)
        function padNumber(num, size) {
            let s = num + "";
            while (s.length < size) s = "0" + s;
            return s;
        }

        // Aquí deberías obtener el siguiente número incremental desde backend, 
        // pero para ejemplo vamos a simular con 1:
        const numeroIncremental = 1;

        // Año actual en 4 dígitos
        const year = new Date().getFullYear();

        // Construcción del código: SIGLA-NAC-0001-2025
        const codigoNacimiento = `${siglaInstitucion}-NAC-${padNumber(numeroIncremental,4)}-${year}`;

        // Asignar el valor al input readonly
        document.getElementById('codigo_nacimiento').value = codigoNacimiento;
    });
</script>
@endsection
