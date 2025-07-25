

<?php $__env->startSection('title', 'Editar Transferencia'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">✏️ Editar Transferencia</h2>

    <?php if($transferencia->estado != 'pendiente'): ?>
        <div class="bg-yellow-200 text-yellow-800 p-3 rounded mb-4">
            Esta transferencia ya fue <strong><?php echo e($transferencia->estado); ?></strong> y no puede ser modificada ni eliminada.
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('transferencias.update', $transferencia->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <fieldset <?php echo e($transferencia->estado != 'pendiente' ? 'disabled' : ''); ?>>
            <div class="mb-4">
                <label for="fauna_id" class="block font-medium">Animal</label>
                <select name="fauna_id" id="fauna_id" required class="w-full border rounded p-2">
                    <option value="">Seleccione un animal</option>
                    <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($fauna->id); ?>"
                            data-especie="<?php echo e($fauna->especie); ?>"
                            data-nombre_comun="<?php echo e($fauna->nombre_comun); ?>"
                            <?php echo e($transferencia->fauna_id == $fauna->id ? 'selected' : ''); ?>>
                            <?php echo e($fauna->codigo); ?> - <?php echo e($fauna->especie); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="mb-4">
                <p class="italic text-gray-600" id="info-especie">
                    
                </p>
                <p class="text-gray-800 font-semibold" id="info-nombre">
                    
                </p>
            </div>

            <div class="mb-4">
    <label for="institucion_origen" class="block font-medium">Institución Origen</label>
    <select name="institucion_origen" class="w-full border rounded p-2" required>
        <?php $__currentLoopData = $instituciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institucion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($institucion->id); ?>"
                <?php echo e($transferencia->institucion_origen == $institucion->id ? 'selected' : ''); ?>>
                <?php echo e($institucion->nombre); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="mb-4">
    <label for="institucion_destino" class="block font-medium">Institución Destino</label>
    <select name="institucion_destino" class="w-full border rounded p-2" required>
        <?php $__currentLoopData = $instituciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institucion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($institucion->nombre); ?>"
    <?php echo e($transferencia->institucion_destino == $institucion->nombre ? 'selected' : ''); ?>>
    <?php echo e($institucion->nombre); ?>

</option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

            <div class="mb-4">
                <label for="motivo" class="block font-medium">Motivo</label>
                <input type="text" name="motivo" value="<?php echo e($transferencia->motivo); ?>" class="w-full border rounded p-2" />
            </div>

            <div class="mb-4">
                <label for="estado" class="block font-medium">Estado</label>
                <select name="estado" class="w-full border rounded p-2" required>
                    <option value="pendiente" <?php echo e($transferencia->estado == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                    <option value="aceptado" <?php echo e($transferencia->estado == 'aceptado' ? 'selected' : ''); ?>>Aceptado</option>
                    <option value="rechazado" <?php echo e($transferencia->estado == 'rechazado' ? 'selected' : ''); ?>>Rechazado</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="fecha_transferencia" class="block font-medium">Fecha de Transferencia</label>
                <input type="date" name="fecha_transferencia" value="<?php echo e($transferencia->fecha_transferencia); ?>" class="w-full border rounded p-2" />
            </div>
        </fieldset>

        <?php if($transferencia->estado == 'pendiente'): ?>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar Solicitud
            </button>
        <?php endif; ?>
    </form>

    
    <div class="mt-6 flex space-x-4">
        <a href="<?php echo e(route('transferencias.pdf', $transferencia->id)); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Descargar PDF
        </a>

        <?php if($transferencia->estado == 'pendiente'): ?>
            <form action="<?php echo e(route('transferencias.destroy', $transferencia->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro que quieres eliminar esta transferencia?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Eliminar Registro
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>


<script>
    function actualizarInfo() {
        const select = document.getElementById('fauna_id');
        const selected = select.options[select.selectedIndex];

        const especie = selected.getAttribute('data-especie');
        const nombre = selected.getAttribute('data-nombre_comun');

        document.getElementById('info-especie').innerText = especie ? `Especie: ${especie}` : '';
        document.getElementById('info-nombre').innerText = nombre ? `Nombre común: ${nombre}` : '';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('fauna_id');
        select.addEventListener('change', actualizarInfo);
        actualizarInfo(); // Mostrar valores al cargar si ya hay uno seleccionado
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/transferencias/edit.blade.php ENDPATH**/ ?>