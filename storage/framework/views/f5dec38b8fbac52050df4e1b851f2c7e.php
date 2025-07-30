

<?php $__env->startSection('title', 'Detalle de Fauna Silvestre'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-lg space-y-8">

    
    <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            📄 Detalle del Registro de Fauna
        </h2>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
            $fields = [
                '📅 Fecha de Ingreso' => $fauna->fecha_ingreso,
                '📥 Fecha de Recepción' => $fauna->fecha_recepcion,
                '🆔 Código Asignado' => $fauna->codigo,
                '🏙️ Ciudad' => $fauna->ciudad,
                '🗺️ Departamento' => $fauna->departamento,
                '📌 Coordenadas' => $fauna->coordenadas,
                '📍 Lugar' => $fauna->lugar,
                '🏛️ Institución Responsable' => $fauna->institucion_remitente,
                '🙋 Persona que Recibe' => $fauna->nombre_persona_recibe,
                '📦 Tipo de Elemento' => $fauna->tipo_elemento,
                '📖 Motivo de Ingreso' => $fauna->motivo_ingreso,

                '🐾 Tipo de Animal' => $fauna->tipo_animal,
                '🌱 Especie' => $fauna->especie,
                '🔤 Nombre Común' => $fauna->nombre_comun,
                '🎂 Edad Aparente' => $fauna->edad_aparente,
                '⚧ Sexo' => ucfirst($fauna->sexo),

                '🩺 Estado General' => $fauna->estado_general,
                '🧠 Comportamiento' => $fauna->comportamiento,
                '🤒 Descripción de Enfermedad' => $fauna->descripcion_enfermedad,
                '🧬 Alteraciones Evidentes' => $fauna->alteraciones_evidentes,

                '📝 Otras Observaciones' => $fauna->otras_observaciones,
                '⏳ Tiempo de Cautiverio' => $fauna->tiempo_cautiverio,
                '🏠 Tipo de Alojamiento' => $fauna->tipo_alojamiento,
                '🐕 Contacto con otros animales' => $fauna->descripcion_contacto,
                '🤕 Padeció Enfermedad' => $fauna->descripcion_padecimiento,
                '🍽️ Tipo de Alimentación' => $fauna->tipo_alimentacion,

                '🏥 Derivado a CCFS' => $fauna->descripcion_derivacion,
            ];
        ?>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-600 font-semibold"><?php echo e($label); ?></p>
                <p class="text-gray-800 mt-1 whitespace-pre-line">
                    <?php if($label === '🌱 Especie'): ?>
                        <span class="italic"><?php echo e($value ?: '—'); ?></span>
                    <?php else: ?>
                        <?php echo e($value ?: '—'); ?>

                    <?php endif; ?>
                </p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="text-center mt-8">
        <p class="text-lg font-semibold text-gray-700 mb-2">📸 Fotografía del Animal</p>
        <?php
            $fotoPath = $fauna->foto ? ('fotos/' . basename($fauna->foto)) : null;
        ?>

        <?php if($fotoPath && Storage::disk('public')->exists($fotoPath)): ?>
            <img src="<?php echo e(asset('storage/' . $fotoPath)); ?>" alt="Foto del animal"
                 class="mx-auto max-w-xs rounded-lg border shadow-md transition-transform hover:scale-105 duration-200">
        <?php else: ?>
            <p class="text-gray-500 italic">No disponible</p>
        <?php endif; ?>
    </div>

    
    <div class="pt-8 flex flex-wrap gap-4 justify-center">
        <a href="<?php echo e(route('fauna.edit', $fauna->id)); ?>"
           class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black font-medium px-5 py-2 rounded-lg shadow transition">
           ✏️ Editar
        </a>

        <a href="<?php echo e(route('fauna.pdf', $fauna->id)); ?>"
           class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-lg shadow transition">
           📄 Exportar PDF
        </a>

        <a href="<?php echo e(route('fauna.index')); ?>"
           class="inline-flex items-center px-4 py-2 bg-white text-blue-600 border border-blue-600 rounded-lg shadow-sm hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver al listado
        </a>
    </div>

</div>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\registro_fauna\resources\views/fauna/show.blade.php ENDPATH**/ ?>