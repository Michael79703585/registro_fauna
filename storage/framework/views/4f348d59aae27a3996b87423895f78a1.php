

<?php $__env->startSection('title', 'Registrar Transferencia'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">🔁 Registrar Transferencia</h2>

    <form action="<?php echo e(route('transferencias.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label for="fauna_id" class="block font-medium">Animal</label>
            <select name="fauna_id" id="fauna_id" required class="w-full border rounded p-2">
                <option value="">Seleccione un animal</option>
                <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option 
                        value="<?php echo e($fauna->id); ?>" 
                        data-especie="<?php echo e($fauna->especie); ?>" 
                        data-nombrecomun="<?php echo e($fauna->nombre_comun ?? 'N/A'); ?>"
                        <?php echo e(old('fauna_id') == $fauna->id ? 'selected' : ''); ?>>
                        <?php echo e($fauna->codigo); ?> - <?php echo e($fauna->especie); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['fauna_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-red-500"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div id="info-fauna" class="mt-2 text-gray-700"></div>
        </div>

        

        <div class="mb-4">
            <label for="institucion_destino" class="block font-medium">Institución Destino</label>
            <select name="institucion_destino" class="form-control">
                <?php $__currentLoopData = $instituciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institucion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($institucion->id); ?>"><?php echo e($institucion->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['institucion_destino'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-red-500"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="motivo" class="block font-medium">Motivo</label>
            <input type="text" name="motivo" value="<?php echo e(old('motivo')); ?>" class="w-full border rounded p-2" />
            <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-red-500"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-4">
            <label for="observaciones" class="block font-medium">Observaciones</label>
            <textarea name="observaciones" rows="3" class="w-full border rounded p-2"><?php echo e(old('observaciones')); ?></textarea>
            <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-red-500"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">
            Enviar Solicitud
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('fauna_id');
        const infoDiv = document.getElementById('info-fauna');

        function updateInfo() {
            const selectedOption = select.options[select.selectedIndex];
            if (select.value === "") {
                infoDiv.innerHTML = "";
                return;
            }
            const especie = selectedOption.getAttribute('data-especie') || '';
            const nombreComun = selectedOption.getAttribute('data-nombrecomun') || '';

            infoDiv.innerHTML = `<p><em>Especie:</em> ${especie}</p>
                                 <p><em>Nombre común:</em> ${nombreComun}</p>`;
        }

        updateInfo();

        select.addEventListener('change', updateInfo);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/transferencias/create.blade.php ENDPATH**/ ?>