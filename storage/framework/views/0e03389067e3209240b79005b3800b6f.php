

<?php $__env->startSection('title', 'Lista de Eventos'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full min-h-screen bg-white py-100 px-100">
    <div class="max-w-7xl mx-auto shadow rounded-lg bg-white">
        <h2 class="text-2xl font-bold mb-6">📌 EVENTOS RECIENTES</h2>

        <?php if(session('success')): ?>
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="mb-6 flex flex-wrap gap-3">
            <a href="<?php echo e(route('eventos.create', ['tipo' => 'Nacimiento'])); ?>" class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700 transition">
                🐣 Nuevo Nacimiento
            </a>
            <a href="<?php echo e(route('eventos.create', ['tipo' => 'Fuga'])); ?>" class="px-4 py-2 bg-yellow-500 text-black rounded hover:bg-yellow-600 transition">
                🏃 Nueva Fuga
            </a>
            <a href="<?php echo e(route('eventos.create', ['tipo' => 'Deceso'])); ?>" class="px-4 py-2 bg-red-600 text-black rounded hover:bg-red-700 transition">
                🕊️ Nuevo Deceso
            </a>
        </div>

        <div class="overflow-x-auto max-h-[75vh] border border-gray-300 rounded">
            <table class="w-full table-auto border-collapse text-sm">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="text-center">
                        <th class="border border-gray-300 px-2 py-2">Código</th>
                        <th class="border border-gray-300 px-2 py-2">Tipo Evento</th>
                        <th class="border border-gray-300 px-2 py-2">Fecha</th>
                        <th class="border border-gray-300 px-2 py-2">Especie</th>
                        <th class="border border-gray-300 px-2 py-2">Nombre Común</th>
                        <th class="border border-gray-300 px-2 py-2">Institución</th>
                        <th class="border border-gray-300 px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-center even:bg-gray-50">
                            <td class="border border-gray-300 px-2 py-2"><?php echo e($evento->codigo); ?></td>
                            <td class="border border-gray-300 px-2 py-2"><?php echo e($evento->tipoEvento->nombre ?? '-'); ?></td>
                            <td class="border border-gray-300 px-2 py-2"><?php echo e(optional($evento->fecha)->format('d/m/Y')); ?></td>
                            <td class="border border-gray-300 px-2 py-2 italic"><?php echo e($evento->especie ?? 'N/A'); ?></td>

                            <td class="border border-gray-300 px-2 py-2"><?php echo e($evento->nombre_comun ?? 'N/A'); ?></td>
                            <td class="border border-gray-300 px-2 py-2"><?php echo e($evento->institucion->nombre ?? 'N/A'); ?></td>
                            <td class="border border-gray-300 px-2 py-2 space-y-1">
                                <a href="<?php echo e(route('eventos.exportar_pdf_individual', $evento->id)); ?>" class="text-indigo-600 hover:underline block">📄 PDF</a>
                                <a href="<?php echo e(route('eventos.show', $evento->id)); ?>" class="text-blue-600 hover:underline block">👁️ Ver</a>
                                <a href="<?php echo e(route('eventos.edit', $evento->id)); ?>" class="text-yellow-600 hover:underline block">✏️ Editar</a>
                                <form action="<?php echo e(route('eventos.destroy', $evento->id)); ?>" method="POST" onsubmit="return confirm('¿Eliminar este evento?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:underline">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                No hay eventos registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <?php echo e($eventos->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigo = document.getElementById('codigo');
    if (codigo) {
        console.log('Valor del código:', codigo.value);
    } else {
        console.warn('Elemento #codigo no encontrado, evitando error');
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/index.blade.php ENDPATH**/ ?>