

<?php $__env->startSection('title', 'Editar Evento de Fuga'); ?>

<?php $__env->startSection('content'); ?>
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
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea 
                name="descripcion" 
                id="descripcion" 
                class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                required
                aria-describedby="descripcionHelp"
            ><?php echo e(old('descripcion', $evento->descripcion)); ?></textarea>
            <?php $__errorArgs = ['descripcion'];
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

        <div class="btn-group">
            <a href="<?php echo e(route('eventos.index')); ?>" class="btn btn-secondary" role="button" aria-label="Cancelar y volver al listado de eventos">
                Cancelar
            </a>
            <button type="submit" class="btn btn-warning" aria-label="Guardar cambios del evento de fuga">
                Actualizar Fuga
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/edit_fuga.blade.php ENDPATH**/ ?>