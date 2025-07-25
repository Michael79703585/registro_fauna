<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico Filtrado</title>
    <style>
        @page {
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        thead {
            background-color: #2980b9;
            color: white;
            font-weight: 600;
        }
        thead th {
            padding: 8px 10px;
            text-align: center;
            border: 1px solid #1c5980;
        }
        tbody td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            vertical-align: middle;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f7f9fc;
        }
        tbody tr:hover {
            background-color: #d6eaf8;
        }
        p {
            text-align: center;
            color: #666;
            font-style: italic;
            margin-top: 40px;
        }

         tbody td.especie {
    font-style: italic;
  }
    </style>
</head>
<body>
    <h1>Historial Clínico Filtrado</h1>

    <?php if($historiales->isEmpty()): ?>
        <p>No se encontraron resultados con los filtros aplicados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha de Recepción</th>
                    <th>Departamento</th>
                    <th>Ciudad</th>
                    <th>Tipo de Animal</th>
                    <th>Nombre Común</th>
                    <th>Especie</th>
                    <th>Edad Aparente</th>
                    <th>Sexo</th>
                    <th>Comportamiento</th>
                    <th>Otras Observaciones</th>
                    <th>Fecha (Historial)</th>
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                    <th>Evolución</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $historiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($historial->fauna->codigo ?? ''); ?></td>
                        <td><?php echo e(optional($historial->fauna->created_at)->format('Y-m-d') ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->departamento ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->ciudad ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->tipo_animal ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->nombre_comun ?? ''); ?></td>
                        <td class="especie"><?php echo e($historial->fauna->especie ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->edad_aparente ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->sexo ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->comportamiento ?? ''); ?></td>
                        <td><?php echo e($historial->fauna->otras_observaciones ?? ''); ?></td>
                        <td><?php echo e($historial->fecha ? $historial->fecha->format('Y-m-d') : ''); ?></td>
                        <td><?php echo e($historial->diagnostico); ?></td>
                        <td><?php echo e($historial->tratamiento); ?></td>
                        <td><?php echo e($historial->observaciones); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/historial/reporte-pdf.blade.php ENDPATH**/ ?>