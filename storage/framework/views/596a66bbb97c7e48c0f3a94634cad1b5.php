

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto p-8 bg-white rounded-2xl shadow-xl space-y-10 mt-10">

    
    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3 border-b border-gray-300 pb-4">
        📄 Detalle de la Parte / Derivado
    </h1>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-800 text-base">

        <?php
            $fields = [
                '🆔 Código' => $parte->codigo,
                '📋 Tipo de Registro' => ucfirst(str_replace('_', ' ', $parte->tipo_registro)),
                '📅 Fecha de Recepción' => \Carbon\Carbon::parse($parte->fecha_recepcion)->format('d/m/Y'),
                '🏙️ Ciudad' => $parte->ciudad,
                '🗺️ Departamento' => $parte->departamento,
                '📍 Coordenadas' => $parte->coordenadas,
                '🏛️ Institución' => $parte->institucion_remitente,
                '🙋 Persona que Recibe' => $parte->nombre_persona_recibe,
                '📦 Tipo de Elemento' => $parte->tipo_elemento,
                '📖 Motivo de Ingreso' => ucfirst($parte->motivo_ingreso),
                '🔢 Cantidad' => $parte->cantidad,
                '🐾 Tipo de Animal' => $parte->tipo_animal,
                '🌿 Especie' => $parte->especie,
                '📛 Nombre Común' => $parte->nombre_comun,
                '📅 Fecha de Disposición' => \Carbon\Carbon::parse($parte->fecha)->format('d/m/Y'),
                '🏁 Disposición Final' => $parte->disposicion_final,
            ];
        ?>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <p class="text-sm font-semibold text-gray-500"><?php echo e($label); ?></p>
                <p class="mt-1 text-gray-900 leading-relaxed whitespace-pre-line">
                    <?php if($label === '🐾 Tipo de Animal'): ?>
                        <?php switch($value):
                            case ('Mamífero'): ?> 🐾 <?php break; ?>
                            <?php case ('Ave'): ?> 🐦 <?php break; ?>
                            <?php case ('Reptil'): ?> 🐍 <?php break; ?>
                            <?php case ('Anfibio'): ?> 🐸 <?php break; ?>
                            <?php default: ?> 🦎
                        <?php endswitch; ?>
                        <?php echo e(ucfirst($value)); ?>

                    <?php elseif($label === '🌿 Especie'): ?>
                        <span class="italic"><?php echo e($value ?: '—'); ?></span>
                    <?php else: ?>
                        <?php echo e($value ?: '—'); ?>

                    <?php endif; ?>
                </p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <div class="md:col-span-2 bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <p class="text-sm font-semibold text-gray-500 mb-1">📝 Observaciones</p>
            <p class="text-gray-900 whitespace-pre-line"><?php echo e($parte->observaciones ?: '—'); ?></p>
        </div>

        
        <div class="md:col-span-2 text-center mt-6">
            <p class="text-xl font-semibold text-gray-700 mb-4">📸 Fotografía</p>
            <?php if($parte->foto && file_exists(public_path('storage/partes_fotos/' . $parte->foto))): ?>
                <img src="<?php echo e(asset('storage/partes_fotos/' . $parte->foto)); ?>" alt="Foto"
                     class="mx-auto max-w-md rounded-2xl border border-gray-300 shadow-lg transition-transform hover:scale-105 duration-300">
            <?php else: ?>
                <p class="italic text-gray-400">Foto no disponible</p>
            <?php endif; ?>
        </div>

    </div>

    
    <div class="pt-10 flex flex-wrap justify-center md:justify-start gap-6">
        <a href="<?php echo e(route('partes.edit', $parte->id)); ?>"
           class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
            ✏️ Editar
        </a>

        <a href="<?php echo e(route('partes.index')); ?>"
           class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-medium px-6 py-3 rounded-xl shadow transition duration-300">
            🔙 Volver
        </a>

        <a href="<?php echo e(route('partes.pdf', $parte->id)); ?>"
           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition duration-300">
            📄 Descargar PDF
        </a>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/partes/show.blade.php ENDPATH**/ ?>