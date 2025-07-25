<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Eventos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11.5px;
            margin: 20px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background-color: #e6e6e6;
            font-weight: bold;
            text-align: center;
        }

        td {
            text-align: left;
        }

        .italic {
            font-style: italic;
        }
    </style>
</head>
<body>
    <h2>📄 Reporte de Eventos Registrados</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Evento</th>
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
            <?php $__empty_1 = true; $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="text-align:center;"><?php echo e($evento->id); ?></td>
                    <td style="text-align:center;"><?php echo e($evento->tipoEvento->nombre ?? '-'); ?></td>
                    <td style="text-align:center;"><?php echo e($evento->codigo ?? '-'); ?></td>
                    <td><?php echo e($evento->especie ?? '-'); ?></td>
                    <td><?php echo e($evento->nombre_comun ?? '-'); ?></td>
                    <td style="text-align:center;"><?php echo e($evento->sexo ?? '-'); ?></td>
                    <td style="text-align:center;"><?php echo e(\Carbon\Carbon::parse($evento->fecha)->format('d/m/Y')); ?></td>
                    <td><?php echo e($evento->institucion->nombre ?? '-'); ?></td>
                    <td><?php echo e($evento->observaciones ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10" style="text-align: center;" class="italic">No se encontraron eventos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/reporte_pdf.blade.php ENDPATH**/ ?>