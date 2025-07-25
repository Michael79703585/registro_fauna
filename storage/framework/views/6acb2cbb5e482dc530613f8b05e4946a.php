

<?php $__env->startSection('title', 'Editar Evento de Deceso'); ?>

<?php $__env->startSection('content'); ?>
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
                <a href="<?php echo e(route('eventos.index')); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al listado
                </a>
            </div>
        </div>

        
        <form action="<?php echo e(route('eventos.update', $evento->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="tipo_evento_id" value="<?php echo e($evento->tipo_evento_id); ?>">

            
            <div class="mb-4">
                <label for="fecha" class="form-label">Fecha del Deceso</label>
                <input type="date" name="fecha" id="fecha" class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('fecha', $evento->fecha->format('Y-m-d'))); ?>" required>
                <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-4">
                <label for="causas_deceso" class="form-label">Causas del Deceso</label>
                <input type="text" name="causas_deceso" id="causas_deceso" class="form-control <?php $__errorArgs = ['causas_deceso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('causas_deceso', $evento->causas_deceso)); ?>" placeholder="Ej. Enfermedad, Accidente..." required>
                <?php $__errorArgs = ['causas_deceso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>


            
            <div class="mb-4">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3" class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Notas adicionales..."><?php echo e(old('observaciones', $evento->observaciones)); ?></textarea>
                <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-4">
                <label class="form-label">Foto del Evento</label><br>
                <img id="preview-image" src="<?php echo e($evento->foto ? asset('storage/eventos/' . $evento->foto) : 'https://via.placeholder.com/180x120?text=Sin+Foto'); ?>" alt="Vista previa de la foto" class="img-preview mb-3" width="180" height="120">
                <input type="file" name="foto" id="foto" class="form-control mt-2 <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".jpg,.jpeg,.png">
                <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG. Máx: 2MB.</small>
                <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="d-flex justify-content-between pt-3">
                <a href="<?php echo e(route('eventos.index')); ?>" class="btn btn-secondary-custom btn-animated px-4">
                    <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-danger-custom btn-animated px-4">
                    <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>


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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/edit_deceso.blade.php ENDPATH**/ ?>