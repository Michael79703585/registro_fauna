


<?php $__env->startSection('title', 'Editar Liberación'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6 text-center">✏️ Editar Liberación</h1>

    <?php if($errors->any()): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('liberaciones.update', $liberacion->id)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
<div>
    <label for="fauna_id" class="block font-semibold mb-1">Animal Asociado</label>
    <select name="fauna_id" id="fauna_id" required class="w-full border px-4 py-2 rounded">
        <option value="">Seleccionar Animal</option>
        <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($fauna->id); ?>" 
                <?php echo e(old('fauna_id', $liberacion->fauna_id) == $fauna->id ? 'selected' : ''); ?>>
                <?php echo e($fauna->codigo); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

      
        
        
        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha</label>
            <input type="date"
                   name="fecha"
                   id="fecha"
                   value="<?php echo e(old('fecha', $liberacion->fecha)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="lugar_liberacion" class="block font-semibold mb-1">Lugar de Liberación</label>
            <input type="text"
                   name="lugar_liberacion"
                   id="lugar_liberacion"
                   value="<?php echo e(old('lugar_liberacion', $liberacion->lugar_liberacion)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="departamento" class="block font-semibold mb-1">Departamento</label>
            <input type="text"
                   name="departamento"
                   id="departamento"
                   value="<?php echo e(old('departamento', $liberacion->departamento)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="municipio" class="block font-semibold mb-1">Municipio</label>
            <input type="text"
                   name="municipio"
                   id="municipio"
                   value="<?php echo e(old('municipio', $liberacion->municipio)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
             <label for="coordenadas" class="block text-sm font-medium text-gray-700">Coordenadas</label>
<input type="text" id="coordenadas" name="coordenadas" value="<?php echo e(old('coordenadas', $registroDuplicado->coordenadas ?? '')); ?>" class="w-full border-gray-300 rounded-md shadow-sm">

<div id="map" class="mt-4" style="height: 400px;"></div>
            </div>
      

        
        <div>
            <label for="tipo_animal" class="block font-semibold mb-1">Tipo de Animal</label>
            <input type="text"
                   name="tipo_animal"
                   id="tipo_animal"
                   value="<?php echo e(old('tipo_animal', $liberacion->tipo_animal)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="especie" class="block font-semibold mb-1">Especie</label>
            <input type="text"
                   name="especie"
                   id="especie"
                   value="<?php echo e(old('especie', $liberacion->especie)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="nombre_comun" class="block font-semibold mb-1">Nombre Común</label>
            <input type="text"
                   name="nombre_comun"
                   id="nombre_comun"
                   value="<?php echo e(old('nombre_comun', $liberacion->nombre_comun)); ?>"
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="responsable" class="block font-semibold mb-1">Responsable</label>
            <input type="text"
                   name="responsable"
                   id="responsable"
                   value="<?php echo e(old('responsable', $liberacion->responsable)); ?>"
                   required
                   class="w-full border px-4 py-2 rounded">
        </div>

        
        <div>
            <label for="institucion" class="block font-semibold mb-1">Institución</label>
            <input type="text"
                   id="institucion"
                   name="institucion"
                   readonly
                   value="<?php echo e(old('institucion', $liberacion->institucion)); ?>"
                   class="w-full border px-4 py-2 rounded bg-gray-100">
        </div>

        
        <div>
            <label for="observaciones" class="block font-semibold mb-1">Observaciones</label>
            <textarea name="observaciones"
                      id="observaciones"
                      rows="3"
                      class="w-full border px-4 py-2 rounded"><?php echo e(old('observaciones', $liberacion->observaciones)); ?></textarea>
        </div>

        
        <div>
            <label for="foto" class="block font-semibold mb-1">Fotografía</label>
            <input type="file"
                   name="foto"
                   id="foto"
                   class="w-full border px-4 py-2 rounded bg-white 
                          file:mr-4 file:py-2 file:px-4 file:border-0 
                          file:text-sm file:bg-blue-100 file:text-blue-700 
                          hover:file:bg-blue-200">
            <?php if($liberacion->foto): ?>
                <p class="mt-2">
                    Foto actual:
                    <a href="<?php echo e(asset('storage/' . $liberacion->foto)); ?>" target="_blank" class="text-blue-500 underline">
                        Ver imagen
                    </a>
                </p>
            <?php endif; ?>
        </div>

        
        <div class="flex justify-between items-center mt-6 max-w-md mx-auto p-4 bg-white rounded shadow">
            <a href="<?php echo e(route('liberaciones.index')); ?>"
               class="text-blue-600 font-semibold hover:text-blue-800 hover:underline transition-colors duration-300">
                ← Cancelar
            </a>

            <button type="submit"
                    class="bg-yellow-600 text-white font-semibold px-6 py-2 rounded shadow-md 
                           hover:bg-yellow-700 hover:scale-105 transform transition duration-300 ease-in-out
                           focus:outline-none focus:ring-4 focus:ring-yellow-300">
                Actualizar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/liberaciones/edit.blade.php ENDPATH**/ ?>