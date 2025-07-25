

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6 text-center">  📑 Editar Historial Clínico</h1>

    <?php if($errors->any()): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('historial.update', $historial->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
            <label for="fauna_id" class="block font-semibold mb-1">Animal</label>
            <select name="fauna_id" id="fauna_id" class="w-full border px-4 py-2 rounded" required>
                <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($fauna->id); ?>" <?php echo e((old('fauna_id', $historial->fauna_id) == $fauna->id) ? 'selected' : ''); ?>>
                        <?php echo e($fauna->codigo); ?> - <?php echo e($fauna->nombre_comun ?? 'Sin nombre'); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo e(old('fecha', $historial->fecha)); ?>" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="bg-gray-50 p-4 rounded">
            <h2 class="text-xl font-bold mb-4">Examen General</h2>

            <?php
                $campos = [
                    'condicion_corporal' => 'Condición Corporal',
                    'boca' => 'Boca',
                    'piel' => 'Piel y Anexos',
                    'musculo_esqueletico' => 'Músculo Esquelético',
                    'abdomen' => 'Abdomen',
                    'frecuencia_cardiaca' => 'Frecuencia Cardíaca',
                    'frecuencia_respiratoria' => 'Frecuencia Respiratoria',
                    'temperatura' => 'Temperatura',
                    'mucosas' => 'Examen de Mucosas',
                    'plumas_pico_garras' => 'En caso de aves: Plumas, Pico, Garras',
                    'caparazon_plastrom' => 'En caso de reptiles: Caparazón, Plastrom, Cabeza, Miembros anteriores y posteriores',
                ];

                $examen_general = old('examen_general') 
                    ?? (is_string($historial->examen_general) ? json_decode($historial->examen_general, true) : ($historial->examen_general ?? []));
            ?>

            <?php $__currentLoopData = $campos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-4">
                    <label for="<?php echo e($name); ?>" class="block font-semibold mb-1"><?php echo e($label); ?></label>
                    <textarea name="examen_general[<?php echo e($name); ?>]" id="<?php echo e($name); ?>" rows="2" class="w-full border px-4 py-2 rounded"><?php echo e($examen_general[$name] ?? ''); ?></textarea>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="mb-4">
                <label for="foto_animal" class="block font-semibold mb-1">Fotografía del Animal</label>
                <?php if(!empty($historial->foto_animal)): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset($historial->foto_animal)); ?>" alt="Foto Animal" class="max-w-xs rounded shadow">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto_animal" id="foto_animal" class="w-full border px-4 py-2 rounded">
            </div>
        </div>

        <div>
            <label for="etologia" class="block font-semibold mb-1">Comportamiento (Etología)</label>
            <textarea name="etologia" id="etologia" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('etologia', $historial->etologia)); ?></textarea>
        </div>

        <div>
            <label for="diagnostico" class="block font-semibold mb-1">Diagnóstico</label>
            <textarea name="diagnostico" id="diagnostico" rows="3" class="w-full border px-4 py-2 rounded" required><?php echo e(old('diagnostico', $historial->diagnostico)); ?></textarea>
        </div>

        <div>
            <label for="tratamiento" class="block font-semibold mb-1">Tratamiento</label>
            <textarea name="tratamiento" id="tratamiento" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('tratamiento', $historial->tratamiento)); ?></textarea>
        </div>

        <div>
            <label for="nutricion" class="block font-semibold mb-1">Nutrición</label>
            <textarea name="nutricion" id="nutricion" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('nutricion', $historial->nutricion)); ?></textarea>
        </div>

        <div>
            <label for="pruebas_laboratorio" class="block font-semibold mb-1">Pruebas de Laboratorio</label>
            <textarea name="pruebas_laboratorio" id="pruebas_laboratorio" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('pruebas_laboratorio', $historial->pruebas_laboratorio)); ?></textarea>
        </div>

<!-- Sección de Pruebas de Laboratorio -->
<div>
    <label for="pruebas_laboratorio" class="block font-semibold mb-1">Pruebas de Laboratorio</label>
    <textarea name="pruebas_laboratorio" id="pruebas_laboratorio" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('pruebas_laboratorio', $historial->pruebas_laboratorio)); ?></textarea>
</div>

<!-- NUEVA SECCIÓN: Cargar PDF o Imagen de Resultados de Laboratorio -->
<div class="mb-6">
    <label for="archivo_laboratorio" class="block font-semibold mb-1">Archivo de Resultados de Laboratorio (PDF o Imagen)</label>
    
    <?php if(!empty($historial->archivo_laboratorio)): ?>
        <div class="mb-2">
            <?php if(Str::endsWith($historial->archivo_laboratorio, ['.jpg', '.jpeg', '.png'])): ?>
                <img src="<?php echo e(asset($historial->archivo_laboratorio)); ?>" alt="Archivo Actual" class="max-w-xs rounded shadow">
            <?php elseif(Str::endsWith($historial->archivo_laboratorio, ['.pdf'])): ?>
                <a href="<?php echo e(asset($historial->archivo_laboratorio)); ?>" target="_blank" class="text-blue-600 underline">Ver archivo PDF actual</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <input type="file" name="archivo_laboratorio" id="archivo_laboratorio" accept=".pdf,image/*" class="w-full border px-4 py-2 rounded">
    <small class="text-gray-500">Opcional. Formatos permitidos: PDF, JPG, PNG.</small>
</div>


        <div>
            <label for="recomendaciones" class="block font-semibold mb-1">Recomendaciones</label>
            <textarea name="recomendaciones" id="recomendaciones" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('recomendaciones', $historial->recomendaciones)); ?></textarea>
        </div>

        <div>
            <label for="observaciones" class="block font-semibold mb-1">Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3" class="w-full border px-4 py-2 rounded"><?php echo e(old('observaciones', $historial->observaciones)); ?></textarea>
        </div>

        <div class="flex justify-between items-center mt-6">

    <!-- Botón Cancelar -->
    <a href="<?php echo e(route('historial.index')); ?>"
   style="display: inline-flex; align-items: center; gap: 6px; font-size: 16px; font-weight: 600; color: #374151; text-decoration: none;"
   onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#374151'">
   <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M15 19l-7-7 7-7" />
   </svg>
   Cancelar
</a>


    <!-- Botón Actualizar -->
    <button type="submit"
            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow transition duration-150">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7" />
        </svg>
        Actualizar
    </button>
</div>

    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/historial/edit.blade.php ENDPATH**/ ?>