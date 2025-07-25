<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exportación PDF - Liberaciones</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; }
        img { max-width: 60px; max-height: 60px; object-fit: cover; }
        .italic { font-style: italic; }
    </style>
</head>
<body>
    <h2>Listado de Liberaciones</h2>

    <table>
        <thead>
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Lugar</th>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Coordenadas</th>
            <th>Tipo Animal</th>
            <th>Especie</th>
            <th>Nombre Común</th>
            <th>Responsable</th>
            <th>Institución</th>
            <th>Observaciones</th>
            <th>Foto</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $liberaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lib): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($lib->codigo); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($lib->fecha)->format('d/m/Y')); ?></td>
                <td><?php echo e($lib->lugar_liberacion); ?></td>
                <td><?php echo e($lib->departamento); ?></td>
                <td><?php echo e($lib->municipio); ?></td>
                <td><?php echo e($lib->coordenadas); ?></td>
                <td><?php echo e($lib->tipo_animal); ?></td>
                <td class="italic"><?php echo e($lib->especie); ?></td>
                <td><?php echo e($lib->nombre_comun); ?></td>
                <td><?php echo e($lib->responsable); ?></td>
                <td><?php echo e($lib->institucion); ?></td>
                <td><?php echo e($lib->observaciones); ?></td>
                <td>
                    <?php if($lib->foto): ?>
                        <img src="<?php echo e(public_path('storage/' . $lib->foto)); ?>" alt="Foto">
                    <?php else: ?>
                        Sin foto
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/liberaciones/pdf.blade.php ENDPATH**/ ?>