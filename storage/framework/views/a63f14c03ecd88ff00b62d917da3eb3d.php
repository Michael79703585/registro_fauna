

<?php $__env->startSection('title', 'Editar Evento de Nacimiento'); ?>

<?php $__env->startSection('content'); ?>
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

    <form action="<?php echo e(route('eventos.update', $evento->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" name="tipo_evento_id" value="<?php echo e($evento->tipo_evento_id); ?>">

        <div class="mb-4">
            <label for="fecha" class="form-label">Fecha</label>
            <input
                type="date"
                name="fecha"
                id="fecha"
                class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('fecha', $evento->fecha->format('Y-m-d'))); ?>"
                required
                aria-describedby="fechaHelp"
            >
            <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="especie" class="form-label">Especie</label>
            <input
                type="text"
                name="especie"
                id="especie"
                class="form-control <?php $__errorArgs = ['especie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('especie', $evento->especie)); ?>"
                required
                aria-describedby="especieHelp"
            >
            <?php $__errorArgs = ['especie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="nombre_comun" class="form-label">Nombre Común</label>
            <input
                type="text"
                name="nombre_comun"
                id="nombre_comun"
                class="form-control <?php $__errorArgs = ['nombre_comun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('nombre_comun', $evento->nombre_comun)); ?>"
                aria-describedby="nombreComunHelp"
            >
            <?php $__errorArgs = ['nombre_comun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="sexo" class="form-label">Sexo</label>
            <select
                name="sexo"
                id="sexo"
                class="form-select <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                aria-describedby="sexoHelp"
            >
                <option value="">Seleccione</option>
                <option value="Macho" <?php echo e(old('sexo', $evento->sexo) == 'Macho' ? 'selected' : ''); ?>>Macho</option>
                <option value="Hembra" <?php echo e(old('sexo', $evento->sexo) == 'Hembra' ? 'selected' : ''); ?>>Hembra</option>
                <option value="Desconocido" <?php echo e(old('sexo', $evento->sexo) == 'Desconocido' ? 'selected' : ''); ?>>Desconocido</option>
            </select>
            <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="senas_particulares" class="form-label">Señas Particulares</label>
            <textarea
                name="senas_particulares"
                id="senas_particulares"
                class="form-control <?php $__errorArgs = ['senas_particulares'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                aria-describedby="senasHelp"
            ><?php echo e(old('senas_particulares', $evento->senas_particulares)); ?></textarea>
            <?php $__errorArgs = ['senas_particulares'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="codigo_padres" class="form-label">Código de Padres</label>
            <input
                type="text"
                name="codigo_padres"
                id="codigo_padres"
                class="form-control <?php $__errorArgs = ['codigo_padres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('codigo_padres', $evento->codigo_padres)); ?>"
                aria-describedby="codigoPadresHelp"
            >
            <?php $__errorArgs = ['codigo_padres'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="categoria" class="form-label">Categoría</label>
            <select
                name="categoria"
                id="categoria"
                class="form-select <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                aria-describedby="categoriaHelp"
            >
                <option value="">Seleccione</option>
                <option value="mamifero" <?php echo e(old('categoria', $evento->categoria) == 'mamifero' ? 'selected' : ''); ?>>Mamífero</option>
                <option value="ave" <?php echo e(old('categoria', $evento->categoria) == 'ave' ? 'selected' : ''); ?>>Ave</option>
                <option value="reptil" <?php echo e(old('categoria', $evento->categoria) == 'reptil' ? 'selected' : ''); ?>>Reptil</option>
                <option value="anfibio" <?php echo e(old('categoria', $evento->categoria) == 'anfibio' ? 'selected' : ''); ?>>Anfibio</option>
                <option value="otro" <?php echo e(old('categoria', $evento->categoria) == 'otro' ? 'selected' : ''); ?>>Otro</option>
            </select>
            <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea
                name="observaciones"
                id="observaciones"
                class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                aria-describedby="observacionesHelp"
            ><?php echo e(old('observaciones', $evento->observaciones)); ?></textarea>
            <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="foto" class="form-label">Foto actual</label><br>
            <?php if($evento->foto): ?>
                <img src="<?php echo e(asset('storage/eventos/' . $evento->foto)); ?>" alt="Foto Evento" class="foto-previa">
            <?php else: ?>
                <p>No hay foto</p>
            <?php endif; ?>
            <input
                type="file"
                name="foto"
                id="foto"
                class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                accept=".jpg,.jpeg,.png"
                aria-describedby="fotoHelp"
            >
            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="btn-group">
            <a href="<?php echo e(route('eventos.index')); ?>" class="btn btn-secondary" role="button" aria-label="Cancelar y volver al listado de eventos">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary" aria-label="Guardar cambios del evento de nacimiento">
                Actualizar Nacimiento
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/edit_Nacimiento.blade.php ENDPATH**/ ?>