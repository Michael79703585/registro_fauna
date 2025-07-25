

<?php $__env->startSection('title', 'Transferencias'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">📦 TRANSFERENCIAS DE FAUNA SILVESTRE</h1>
        <div class="flex flex-wrap gap-3">
            <a href="<?php echo e(route('transferencias.create')); ?>"
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition text-sm font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Nueva
            </a>

            <a href="<?php echo e(route('transferencias.reportePdf')); ?>"
               style="background-color:#e54646; color:white; padding: 8px 16px; border-radius: 8px; text-decoration:none; display:inline-flex; align-items:center;">
                <i class="fas fa-file-pdf mr-2"></i> Reporte PDF
            </a>

            <a href="<?php echo e(route('transferencias.reporteExcel')); ?>"
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition text-sm font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 4h16v16H4V4z M4 8h16" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Excel
            </a>
        </div>
    </div>

    
    <form method="GET" action="<?php echo e(route('transferencias.index')); ?>"
          class="mb-6 bg-white border border-gray-200 p-6 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="relative">
                <input type="text" name="codigo" value="<?php echo e(request('codigo')); ?>" placeholder="Código"
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-barcode"></i>
                </span>
            </div>

            <div class="relative">
                <input type="date" name="fecha_transferencia" value="<?php echo e(request('fecha_transferencia')); ?>"
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-calendar-alt"></i>
                </span>
            </div>

            <div class="relative">
                <input type="text" name="destino" value="<?php echo e(request('destino')); ?>" placeholder="Institución Destino"
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-map-pin"></i>
                </span>
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <button type="submit"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium shadow-sm">
                <i class="fas fa-search mr-2"></i> Buscar
            </button>
            <a href="<?php echo e(route('transferencias.index')); ?>"
               class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md font-medium shadow-sm">
                <i class="fas fa-times mr-2"></i> Limpiar
            </a>
        </div>
    </form>

    
    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-100 text-green-800 border border-green-300 p-4 rounded-md shadow-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-6 py-4">Código</th>
                    <th class="px-6 py-4">Tipo Animal</th>
                    <th class="px-6 py-4">Especie</th>
                    <th class="px-6 py-4">Origen</th>
                    <th class="px-6 py-4">Destino</th>
                    <th class="px-6 py-4">Fecha</th>
                    <th class="px-6 py-4">Motivo</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__empty_1 = true; $__currentLoopData = $transferencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transferencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"><?php echo e($transferencia->fauna->codigo); ?></td>
                        <td class="px-6 py-4"><?php echo e($transferencia->fauna->tipo_animal ?? 'No definido'); ?></td>
                        <td class="px-6 py-4"><?php echo e($transferencia->fauna->especie); ?></td>
                        <td class="px-6 py-4"><?php echo e($transferencia->institucionOrigen->nombre ?? 'N/A'); ?></td>
                        <td class="px-6 py-4"><?php echo e($transferencia->institucionDestino->nombre ?? 'N/A'); ?></td>
                        <td class="px-6 py-4"><?php echo e($transferencia->fecha_transferencia ?? 'No definida'); ?></td>
                        <td class="px-6 py-4"><?php echo e($transferencia->motivo); ?></td>
                        <td class="px-6 py-4">
                            <?php
                                $estadoColor = match($transferencia->estado) {
                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                    'aceptado' => 'bg-green-100 text-green-800',
                                    'rechazado' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            ?>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo e($estadoColor); ?>">
                                <?php echo e(ucfirst($transferencia->estado)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-2">
                                
                                <a href="<?php echo e(route('transferencias.show', $transferencia->id)); ?>"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs font-semibold shadow transition">
                                    <i class="fas fa-eye"></i> Ver
                                </a>

                                
                                <a href="<?php echo e(route('transferencias.edit', $transferencia->id)); ?>"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-xs font-semibold shadow transition">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                
                                <?php if($transferencia->estado === 'pendiente'): ?>
                                    <form action="<?php echo e(route('transferencias.destroy', $transferencia->id)); ?>" method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar transferencia?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700 text-xs font-semibold shadow transition">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <?php
                                    $userInstitucionId = (int) Auth::user()->institucion_id;
                                    $institucionOrigenId = (int) $transferencia->institucion_origen;
                                ?>
                                <?php if($userInstitucionId === $institucionOrigenId): ?>
                                    <a href="<?php echo e(route('transferencias.pdf', $transferencia->id)); ?>"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-600 text-white hover:bg-green-700 text-xs font-semibold shadow transition">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($userInstitucionId === (int) $transferencia->institucion_destino && $transferencia->estado === 'pendiente'): ?>
                                    <form action="<?php echo e(route('transferencias.changeStatus', $transferencia->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="estado" value="aceptado">
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-green-500 text-white hover:bg-green-600 text-xs font-semibold shadow transition">
                                            <i class="fas fa-check"></i> Aceptar
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('transferencias.changeStatus', $transferencia->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="estado" value="rechazado">
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-500 text-white hover:bg-red-600 text-xs font-semibold shadow transition">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No hay transferencias registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/transferencias/index.blade.php ENDPATH**/ ?>