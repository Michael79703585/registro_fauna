

<?php $__env->startSection('title', 'Todos los Eventos'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .btn-action {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.03em;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-view { background-color: #3498db; color: white; }
    .btn-view:hover { background-color: #2980b9; box-shadow: 0 6px 12px rgba(41, 128, 185, 0.3); }

    .btn-edit { background-color: #f1c40f; color: #2c3e50; }
    .btn-edit:hover { background-color: #d4ac0d; box-shadow: 0 6px 12px rgba(212, 172, 13, 0.3); }

    .btn-delete { background-color: #e74c3c; color: white; }
    .btn-delete:hover { background-color: #c0392b; box-shadow: 0 6px 12px rgba(192, 57, 43, 0.3); }

    .btn-pdf { background-color: #8e44ad; color: white; }
    .btn-pdf:hover { background-color: #732d91; box-shadow: 0 6px 12px rgba(115, 45, 145, 0.3); }

    .btn-back, .btn-export {
        padding: 0.6rem 1.5rem;
        font-weight: 700;
        border-radius: 0.6rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-back {
        background: linear-gradient(to right, #5dade2, #3498db);
        color: white;
    }

    .btn-back:hover {
        background: linear-gradient(to right, #2980b9, #2471a3);
    }

    .btn-export {
        background: linear-gradient(to right, #2ecc71, #27ae60);
        color: white;
    }

    .btn-export:hover {
        background: linear-gradient(to right, #229954, #1e8449);
    }
</style>

<div class="w-full min-h-screen bg-white py-10 px-6">
    <div class="max-w-7xl mx-auto shadow rounded-lg bg-white">
        <h2 class="text-2xl font-bold mb-6">📋 TODOS LOS EVENTOS REGISTRADOS</h2>

         <!-- Filtros -->
        <form method="GET" action="<?php echo e(route('eventos.todos')); ?>" class="mb-6 flex flex-wrap items-end gap-4">
            <div>
                <label for="tipo" class="block font-semibold">Tipo de Evento</label>
                <select name="tipo" id="tipo" class="border rounded px-3 py-2">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = $tiposEvento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tipo->nombre); ?>" <?php echo e(request('tipo') == $tipo->nombre ? 'selected' : ''); ?>><?php echo e($tipo->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>


        <div>
                <label for="codigo" class="block font-semibold">Código Animal</label>
                <input type="text" name="codigo" id="codigo" value="<?php echo e(request('codigo')); ?>" placeholder="Ej: GAC-NAC-0001" class="border rounded px-3 py-2">
            </div>

            <button type="submit" class="btn-export">🔍 Filtrar</button>
            <a href="<?php echo e(route('eventos.todos')); ?>" class="btn-back">↻ Limpiar</a>
            <a href="<?php echo e(route('eventos.exportar_excel')); ?>" class="btn-export">📊 Exportar Tabla a Excel</a>
            <a href="<?php echo e(route('eventos.pdf')); ?>" class="btn-export">📄 Exportar PDF</a>
        </form>

        <?php if(session('success')): ?>
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="overflow-x-auto max-h-[75vh] border border-gray-300 rounded">
            <table class="w-full table-auto border-collapse text-sm">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="text-center">
                        <th class="border px-2 py-2">#</th>
                        <th class="border px-2 py-2">Tipo Evento</th>
                        <th class="border px-2 py-2">Código Animal</th>
                        <th class="border px-2 py-2">Especie</th>
                        <th class="border px-2 py-2">Nombre Común</th>
                        <th class="border px-2 py-2">Sexo</th>
                        <th class="border px-2 py-2">Fecha</th>
                        <th class="border px-2 py-2">Institución</th>
                        <th class="border px-2 py-2 text-left">Motivo / Observaciones</th>
                        <th class="border px-2 py-2">Foto</th>
                        <th class="border px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-center even:bg-gray-50">
                            <td class="border px-2 py-2"><?php echo e($eventos->firstItem() + $loop->index); ?></td>
                            <td class="border px-2 py-2"><?php echo e(optional($evento->tipoEvento)->nombre ?? '-'); ?></td>
                            <td class="border px-2 py-2"><?php echo e($evento->codigo ?? '-'); ?></td>
                            <td class="border px-2 py-2"><?php echo e($evento->especie ?? '-'); ?></td>
                            <td class="border px-2 py-2"><?php echo e($evento->nombre_comun ?? '-'); ?></td>
                            <td class="border px-2 py-2"><?php echo e($evento->sexo ?? '-'); ?></td>
                            <td class="border px-2 py-2"><?php echo e(\Carbon\Carbon::parse($evento->fecha)->format('d/m/Y')); ?></td>
                            <td class="border px-2 py-2"><?php echo e(optional($evento->institucion)->nombre ?? '-'); ?></td>
                            <td class="border px-2 py-2 text-left max-w-xs break-words">
                                <p><strong>Motivo:</strong> <?php echo e($evento->motivo ?? '-'); ?></p>
                                <p><strong>Observaciones:</strong> <?php echo e($evento->observaciones ?? '-'); ?></p>
                            </td>
                            <td class="border px-2 py-2">
                                <?php if($evento->foto && file_exists(public_path("storage/{$evento->foto}"))): ?>
                                    <a href="<?php echo e(asset('storage/' . $evento->foto)); ?>" target="_blank" title="Ver foto">
                                        <img src="<?php echo e(asset('storage/' . $evento->foto)); ?>" alt="Foto" class="h-16 w-16 object-cover rounded mx-auto shadow">
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 italic">Sin foto</span>
                                <?php endif; ?>
                            </td>
                            <td class="border px-2 py-2 space-y-1">
                                <a href="<?php echo e(route('eventos.exportar_pdf_individual', $evento->id)); ?>" class="btn-action btn-pdf block">PDF</a>
                                <a href="<?php echo e(route('eventos.show', $evento->id)); ?>" class="btn-action btn-view block">Ver</a>
                                <a href="<?php echo e(route('eventos.edit', $evento->id)); ?>" class="btn-action btn-edit block">Editar</a>
                                <form action="<?php echo e(route('eventos.destroy', $evento->id)); ?>" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este evento?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-action btn-delete w-full">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center text-gray-500 py-6">No hay eventos registrados.</td>
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
<script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigo = document.getElementById('codigo');
    if (codigo) {
        console.log('Código capturado:', codigo.value);
    } else {
        console.warn('Elemento #codigo no existe en esta vista');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/todos.blade.php ENDPATH**/ ?>