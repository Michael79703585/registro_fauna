<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Transferencias de Fauna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background-color: #2980b9;
            color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .estado-pendiente {
            color: #d4ac0d;
            font-weight: bold;
        }
        .estado-aceptado {
            color: #27ae60;
            font-weight: bold;
        }
        .estado-rechazado {
            color: #c0392b;
            font-weight: bold;
        }
        em {
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Reporte de Transferencias de Fauna Silvestre</h1>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo Animal</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Institución Origen</th>
                <th>Institución Destino</th>
                <th>Fecha Transferencia</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $transferencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($t->fauna->codigo ?? 'N/A'); ?></td>
                    <td><?php echo e($t->fauna->tipo_animal ?? 'N/A'); ?></td>
                    <td><em><?php echo e($t->fauna->especie ?? 'N/A'); ?></em></td>
                    <td><?php echo e($t->fauna->nombre_comun ?? 'N/A'); ?></td>
                    <td><?php echo e($t->institucionOrigen->nombre ?? 'N/A'); ?></td>
                    <td><?php echo e($t->institucionDestino->nombre ?? $t->institucion_destino ?? 'N/A'); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($t->fecha_transferencia)->format('d/m/Y') ?? 'N/A'); ?></td>
                    <td><?php echo e($t->motivo ?? 'N/A'); ?></td>
                    <td class="
                        <?php if($t->estado === 'pendiente'): ?> estado-pendiente
                        <?php elseif($t->estado === 'aceptado'): ?> estado-aceptado
                        <?php elseif($t->estado === 'rechazado'): ?> estado-rechazado
                        <?php else: ?> '' <?php endif; ?>
                    ">
                        <?php echo e(ucfirst($t->estado ?? 'N/A')); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" style="text-align:center;">No hay transferencias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/transferencias/reportPdf.blade.php ENDPATH**/ ?>