

<?php $__env->startSection('title', 'Detalle de Transferencia'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto p-8 bg-white rounded-2xl shadow-xl space-y-10 mt-10">

    
    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3 border-b border-gray-300 pb-4">
        📋 Detalle de Transferencia de Fauna
    </h1>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-800 text-base">

        <?php
    $fields = [
        '🆔 Código' => $transferencia->fauna->codigo ?? 'N/A',
        '🐾 Tipo Animal' => $transferencia->fauna->tipo_animal ?? 'N/A',
        '🌿 Especie' => $transferencia->fauna->especie ?? 'N/A',
        '📅 Fecha de Transferencia' => $transferencia->fecha_transferencia_formateada ?? 'N/A',
        '🏛️ Institución Origen' => $transferencia->institucionOrigen->nombre ?? 'N/A',
        '🏢 Institución Destino' => $transferencia->institucionDestino->nombre ?? 'N/A',
        '📖 Motivo' => $transferencia->motivo ?? 'N/A',
        '📝 Observaciones' => $transferencia->observaciones ?? 'N/A',
        '⚙️ Estado' => $transferencia->estado ?? 'N/A',
    ];
?>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-sm font-semibold text-gray-500"><?php echo e($label); ?></p>
                <p class="mt-1 text-gray-900 leading-relaxed whitespace-pre-line">
                    <?php if($label === '🐾 Tipo Animal'): ?>
                        <?php switch($value):
                            case ('Mamífero'): ?> 🐾 <?php break; ?>
                            <?php case ('Ave'): ?> 🐦 <?php break; ?>
                            <?php case ('Reptil'): ?> 🐍 <?php break; ?>
                            <?php case ('Anfibio'): ?> 🐸 <?php break; ?>
                            <?php default: ?> 🦎
                        <?php endswitch; ?>
                        <?php echo e(ucfirst($value) !== 'N/a' ? ucfirst($value) : '—'); ?>

                    <?php elseif($label === '🌿 Especie'): ?>
                        <span class="italic"><?php echo e($value !== 'N/A' ? $value : '—'); ?></span>
                    <?php elseif($label === '⚙️ Estado'): ?>
                        <?php
                            $estadoColor = match(strtolower($value)) {
                                'pendiente' => 'text-yellow-600 font-semibold',
                                'aceptado' => 'text-green-600 font-semibold',
                                'rechazado' => 'text-red-600 font-semibold',
                                default => 'text-gray-600'
                            };
                        ?>
                        <span class="<?php echo e($estadoColor); ?>"><?php echo e(ucfirst($value) !== 'N/a' ? ucfirst($value) : '—'); ?></span>
                    <?php else: ?>
                        <?php echo e($value !== 'N/A' ? $value : '—'); ?>

                    <?php endif; ?>
                </p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    
    <div class="pt-10 flex flex-wrap justify-center md:justify-start gap-6">
        <a href="<?php echo e(route('transferencias.index')); ?>"
           class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium px-6 py-3 rounded-xl shadow transition duration-300">
            🔙 Volver
        </a>

        <?php if(Auth::user()->institucion_id === $transferencia->institucion_origen): ?>
            <a href="<?php echo e(route('transferencias.pdf', $transferencia->id)); ?>"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
                📄 Descargar PDF
            </a>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/transferencias/show.blade.php ENDPATH**/ ?>