

<?php $__env->startSection('content'); ?>
<section class="bg-gray-100 py-12 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">

        <h2 class="text-3xl font-extrabold text-gray-800 mb-10 text-center">📰 Últimas publicaciones</h2>
<?php if(auth()->guard()->check()): ?>
<div class="flex justify-end mb-6">
    <a href="<?php echo e(route('publicaciones.create')); ?>"
       class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition duration-200">
        <i class="fas fa-plus mr-2"></i> Nueva publicación
    </a>
</div>
<?php endif; ?>

        <!-- Modal visor PDF / IMG -->
        <div x-data="{ show: false, fileUrl: '', isPdf: false }">
            <!-- Modal -->
            <div class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center" x-show="show" x-transition>
                <div class="relative bg-white w-[95%] max-w-4xl rounded-xl overflow-hidden shadow-lg">
                    <button class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-2xl" @click="show = false">
                        &times;
                    </button>

                    <div class="p-4">
                        <template x-if="!isPdf">
                            <img :src="fileUrl" class="w-full max-h-[80vh] object-contain mx-auto rounded" />
                        </template>

                        <template x-if="isPdf">
                            <embed :src="fileUrl" type="application/pdf" class="w-full h-[80vh]" />
                        </template>
                    </div>
                </div>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $publicaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $publicacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl shadow p-6 mb-10 transition hover:shadow-xl">
                <!-- Encabezado -->
                <div class="flex items-center mb-4">
                    <div class="w-11 h-11 bg-blue-600 text-white font-bold rounded-full flex items-center justify-center text-lg">
                        <?php echo e(strtoupper(substr($publicacion->title, 0, 1))); ?>

                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900"><?php echo e($publicacion->title); ?></h3>
                        <p class="text-sm text-gray-500">📅 <?php echo e($publicacion->created_at->format('d/m/Y')); ?></p>
                    </div>
                </div>

                <!-- Archivos -->
                <?php
                    $archivos = json_decode($publicacion->image_path, true) ?? [];
                    $imagenes = collect($archivos)->filter(fn($f) => preg_match('/\.(jpg|jpeg|png|webp)$/i', $f));
                    $pdfs = collect($archivos)->filter(fn($f) => preg_match('/\.pdf$/i', $f));
                ?>

                <?php if($imagenes->count()): ?>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                    <?php $__currentLoopData = $imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/' . $img)); ?>"
                         class="cursor-pointer rounded border shadow hover:scale-105 transition"
                         @click="fileUrl='<?php echo e(asset('storage/' . $img)); ?>'; isPdf=false; show=true" />
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <?php if($pdfs->count()): ?>
                <div class="space-y-3 mb-4">
                    <?php $__currentLoopData = $pdfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between bg-gray-100 p-3 rounded border">
                        <div class="flex items-center gap-2 text-gray-800 truncate">
                            <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                            <span class="text-sm truncate w-52 md:w-64"><?php echo e(basename($pdf)); ?></span>
                        </div>
                        <button @click="fileUrl='<?php echo e(asset('storage/' . $pdf)); ?>'; isPdf=true; show=true"
                                class="text-blue-600 text-sm hover:underline">
                            Ver PDF
                        </button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <!-- Descripción -->
                <p class="text-gray-700 text-sm leading-relaxed mb-6">
                    <?php echo e($publicacion->description); ?>

                </p>

                <!-- Botón Compartir -->
                <div class="relative inline-block group mb-4">
                    <button class="text-sm flex items-center text-gray-600 hover:text-blue-600">
                        <i data-feather="share-2" class="w-4 h-4 mr-1"></i> Compartir
                    </button>
                    <div class="absolute left-0 hidden group-hover:block bg-white border rounded-lg shadow-lg mt-2 z-20 p-3 w-48">
                        <?php
                            $shareUrl = urlencode(request()->fullUrl());
                            $text = urlencode('Mira esta publicación');
                        ?>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($shareUrl); ?>"
                           target="_blank" class="flex items-center gap-2 text-sm hover:text-blue-600 mb-2">
                            <i class="fab fa-facebook-square text-blue-700"></i> Facebook
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?php echo e($text); ?>%20<?php echo e($shareUrl); ?>"
                           target="_blank" class="flex items-center gap-2 text-sm hover:text-green-600 mb-2">
                            <i class="fab fa-whatsapp text-green-500"></i> WhatsApp
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?php echo e($text); ?>&url=<?php echo e($shareUrl); ?>"
                           target="_blank" class="flex items-center gap-2 text-sm hover:text-blue-400 mb-2">
                            <i class="fab fa-twitter text-blue-400"></i> Twitter
                        </a>
                        <a href="mailto:?subject=<?php echo e($text); ?>&body=<?php echo e($shareUrl); ?>"
                           class="flex items-center gap-2 text-sm hover:text-gray-600">
                            <i class="fas fa-envelope text-gray-500"></i> Correo
                        </a>
                    </div>
                </div>

                <!-- Acciones -->
                <?php if(auth()->guard()->check()): ?>
                <div class="flex justify-end gap-6 text-sm">
                    <a href="<?php echo e(route('publicaciones.edit', $publicacion)); ?>" class="text-yellow-600 hover:underline">✏️ Editar</a>
                    <form action="<?php echo e(route('publicaciones.destroy', $publicacion)); ?>" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-500 hover:underline">🗑️ Eliminar</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-gray-500">No hay publicaciones aún.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Feather Icons -->
    <script>feather.replace();</script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/publicaciones/index.blade.php ENDPATH**/ ?>