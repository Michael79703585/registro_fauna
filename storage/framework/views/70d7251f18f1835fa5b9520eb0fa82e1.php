

<?php $__env->startSection('content'); ?>
<section class="bg-gray-100 py-12">
  <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">✏️ Editar publicación</h2>

    <form action="<?php echo e(route('publicaciones.update', $publication->id)); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <!-- Título -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
        <input type="text" name="title" value="<?php echo e(old('title', $publication->title)); ?>"
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-400"
               required>
      </div>

      <!-- Descripción -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
        <textarea name="description" rows="4"
                  class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-400"
                  required><?php echo e(old('description', $publication->description)); ?></textarea>
      </div>

      <!-- Archivos existentes -->
      <div class="mb-6">
        <p class="font-semibold text-gray-700 mb-2">Archivos actuales:</p>
        <div class="space-y-6">
          <?php $__currentLoopData = $publication->image_path; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); ?>

            <div class="border p-3 rounded-md shadow-sm">
              <?php if(in_array($ext, ['jpg','jpeg','png','webp'])): ?>
                <img src="<?php echo e(asset('storage/' . $file)); ?>" alt="Imagen" class="max-w-full h-auto rounded shadow mb-2">
              <?php elseif($ext === 'pdf'): ?>
                <embed src="<?php echo e(asset('storage/' . $file)); ?>" type="application/pdf" width="100%" height="300px" class="rounded shadow mb-2">
              <?php else: ?>
                <a href="<?php echo e(asset('storage/' . $file)); ?>" target="_blank" class="text-blue-600 underline block mb-2">
                  Ver archivo
                </a>
              <?php endif; ?>

              <!-- Botón para eliminar archivo -->
              <form action="<?php echo e(route('publicaciones.file.destroy', [$publication->id, $index])); ?>" method="POST" onsubmit="return confirm('¿Deseas eliminar este archivo?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-red-600 text-sm hover:underline">
                  🗑️ Eliminar archivo
                </button>
              </form>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>

      <!-- Cargar nuevos archivos -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Agregar más archivos (opcional)</label>
        <input type="file" name="files[]" multiple
               class="block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-md file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100">
      </div>

      <!-- Botón Guardar -->
      <div class="text-right">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          💾 Guardar cambios
        </button>
      </div>
    </form>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/publicaciones/edit.blade.php ENDPATH**/ ?>