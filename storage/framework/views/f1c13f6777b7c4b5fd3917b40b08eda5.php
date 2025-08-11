

<?php $__env->startSection('title', 'Liberaciones de Fauna Silvestre'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-blue-700 pb-2">
            📋 REGISTROS DE LIBERACIÓN DE FAUNA SILVESTRE
        </h2>

        <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
            <a href="<?php echo e(route('liberaciones.create')); ?>"
               class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow text-sm font-semibold transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                ➕ Nuevo Registro
            </a>

            <div class="flex gap-2">
                <a href="<?php echo e(route('liberaciones.exportPdf')); ?>"
                   class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 11V3m0 0L8 7m4-4l4 4M6 21h12a2 2 0 002-2v-7H4v7a2 2 0 002 2z"/>
                    </svg>
                    Exportar PDF
                </a>

                <a href="<?php echo e(route('liberaciones.exportExcel')); ?>"
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4h16v16H4V4zm4 4l8 8m0-8l-8 8"/>
                    </svg>
                    Exportar Excel
                </a>
            </div>
        </div>

        
        <form action="<?php echo e(route('liberaciones.index')); ?>" method="GET"
              class="mb-6 bg-gray-50 p-4 rounded-lg shadow border border-gray-200 flex flex-wrap gap-6 items-end">
            <div>
                <label for="codigo" class="block mb-1 font-medium text-sm text-gray-700">Buscar por código</label>
                <input type="text" name="codigo" id="codigo" placeholder="Código" value="<?php echo e(request('codigo')); ?>"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="fecha_inicio" class="block mb-1 font-medium text-sm text-gray-700">Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo e(request('fecha_inicio')); ?>"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <label for="fecha_fin" class="block mb-1 font-medium text-sm text-gray-700">Fecha fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo e(request('fecha_fin')); ?>"
                       class="border border-gray-300 rounded px-3 py-2 shadow-sm text-sm text-gray-800">
            </div>

            <div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-semibold transition duration-200">
                    Filtrar
                </button>
            </div>
        </form>

        
        <div class="overflow-auto">
            <table class="min-w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-blue-50 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-3 py-2 border">Código</th>
                    <th class="px-3 py-2 border">Fecha</th>
                    <th class="px-3 py-2 border">Lugar</th>
                    <th class="px-3 py-2 border">Departamento</th>
                    <th class="px-3 py-2 border">Municipio</th>
                    <th class="px-3 py-2 border">Coordenadas</th>
                    <th class="px-3 py-2 border">Tipo Animal</th>
                    <th class="px-3 py-2 border">Especie</th>
                    <th class="px-3 py-2 border">Nombre Común</th>
                    <th class="px-3 py-2 border">Responsable</th>
                    <th class="px-3 py-2 border">Institución</th>
                    <th class="px-3 py-2 border">Observaciones</th>
                    <th class="px-3 py-2 border">Fotografía</th>
                    <th class="px-3 py-2 border">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $liberaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liberacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-blue-50 transition">
                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->codigo); ?></td>

                        
                        <td class="px-3 py-2 border">
                            <?php echo e(\Carbon\Carbon::parse($liberacion->fecha)->format('d/m/Y')); ?>

                        </td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->lugar_liberacion); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->departamento); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->municipio); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->coordenadas); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->tipo_animal); ?></td>

                        
                        <td class="px-3 py-2 border italic"><?php echo e($liberacion->especie); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->nombre_comun); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->responsable); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->institucion); ?></td>

                        
                        <td class="px-3 py-2 border"><?php echo e($liberacion->observaciones); ?></td>

                        
<td class="px-3 py-2 border text-center">
    <?php
        $rutaFoto = storage_path('app/public/' . $liberacion->foto);
    ?>

    <?php if($liberacion->foto && file_exists($rutaFoto)): ?>
        <img src="<?php echo e(asset('storage/' . $liberacion->foto)); ?>" alt="Foto de liberación"
             class="h-12 w-12 object-cover rounded">
    <?php else: ?>
        <span class="text-gray-400">Sin foto</span>
    <?php endif; ?>
</td>


                        
<td class="px-3 py-2 border text-center">
    <div class="flex flex-wrap justify-center gap-1">
        
        <a href="<?php echo e(route('liberaciones.show', $liberacion->id)); ?>"
           class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs shadow">
            Ver
        </a>

        
         <a href="<?php echo e(route('liberaciones.exportPdfIndividual', $liberacion->id)); ?>"
           class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-600 text-white hover:bg-green-700 text-xs shadow transition"
           target="_blank" title="Descargar PDF">
            PDF
        </a>

        
        <a href="<?php echo e(route('liberaciones.edit', $liberacion->id)); ?>"
           class="inline-flex items-center gap-1 px-2 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-xs shadow">
            Editar
        </a>

        
        <form action="<?php echo e(route('liberaciones.destroy', $liberacion->id)); ?>" method="POST"
              class="inline-block" onsubmit="return confirm('¿Eliminar este registro?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit"
                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700 text-xs shadow">
                Eliminar
            </button>
        </form>
    </div>
</td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="14" class="text-center px-4 py-6 text-gray-500">No hay registros disponibles.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-6 flex justify-center">
            <?php echo e($liberaciones->links()); ?>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/liberaciones/index.blade.php ENDPATH**/ ?>