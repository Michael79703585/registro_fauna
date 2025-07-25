

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-12 px-6 bg-white rounded-lg shadow-md">

    
    <div class="mb-6">
        <a href="<?php echo e(route('publicaciones.index')); ?>" class="inline-flex items-center text-sm text-gray-600 hover:text-green-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a publicaciones
        </a>
    </div>

    
    <h1 class="text-4xl font-extrabold text-green-900 mb-2"><?php echo e($publication->title); ?></h1>

    
    <p class="text-sm text-gray-500 mb-6">
        Publicado el: <?php echo e($publication->created_at->format('d \d\e F, Y')); ?>

    </p>

    
    <div class="prose prose-green max-w-none mb-10">
        <?php echo nl2br(e($publication->description)); ?>

    </div>

    
    <section>
        <h2 class="text-2xl font-semibold text-green-800 mb-4">Archivos adjuntos</h2>
        <?php
            $files = json_decode($publication->image_path, true);
        ?>

        <?php if($files && count($files) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-lg overflow-hidden shadow-sm bg-gray-50 p-4 flex flex-col items-center">
                        <?php if(Str::endsWith($file, ['.jpg', '.jpeg', '.png', '.webp'])): ?>
                            <img src="<?php echo e(asset('storage/' . $file)); ?>" alt="Imagen" class="max-h-64 object-contain rounded mb-4 w-full" />
                            <a href="<?php echo e(asset('storage/' . $file)); ?>" target="_blank" class="text-green-700 hover:underline text-sm">Ver imagen completa</a>
                        <?php elseif(Str::endsWith($file, '.pdf')): ?>
                            <embed src="<?php echo e(asset('storage/' . $file)); ?>" type="application/pdf" class="w-full h-64 rounded mb-4" />
                            <a href="<?php echo e(asset('storage/' . $file)); ?>" target="_blank" class="text-green-700 hover:underline text-sm">Abrir PDF en nueva pestaña</a>
                        <?php else: ?>
                            <a href="<?php echo e(asset('storage/' . $file)); ?>" download class="text-green-700 hover:underline text-sm">Descargar archivo</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 italic">No hay archivos adjuntos.</p>
        <?php endif; ?>
    </section>

    
    <?php if(auth()->guard()->check()): ?>
    <div class="mt-10 flex gap-4">
        <a href="<?php echo e(route('publicaciones.edit', $publication->id)); ?>"
           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded transition text-sm">
            ✏️ Editar
        </a>

        <form action="<?php echo e(route('publicaciones.destroy', $publication->id)); ?>" method="POST"
              onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit"
                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded transition text-sm">
                🗑️ Eliminar
            </button>
        </form>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/publicaciones/show.blade.php ENDPATH**/ ?>