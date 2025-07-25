<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Evento</th>
                <th>Código Animal</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Sexo</th>
                <th>Fecha</th>
                <th>Institución</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e($evento->tipoEvento->nombre ?? '-'); ?></td>
                    <td><?php echo e($evento->codigo ?? '-'); ?></td>
                    <td><?php echo e($evento->especie ?? $evento->fauna->especie ?? '-'); ?></td>
                    <td><?php echo e($evento->nombre_comun ?? $evento->fauna->nombre_comun ?? '-'); ?></td>
                    <td><?php echo e($evento->sexo ?? $evento->fauna->sexo ?? '-'); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($evento->fecha)->format('d/m/Y')); ?></td>
                    <td><?php echo e($evento->institucion->nombre ?? '-'); ?></td>
                    <td><?php echo e($evento->observaciones ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/exportar_excel.blade.php ENDPATH**/ ?>