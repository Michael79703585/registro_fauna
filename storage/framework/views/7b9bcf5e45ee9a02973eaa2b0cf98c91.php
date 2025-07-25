<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Partes</title>
    <style>
    @page {
        size: letter landscape;
        margin: 1cm;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 8px; /* Reducido un poco para que quepa mejor */
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed; /* Fija el ancho de columnas */
        word-wrap: break-word;
    }

    th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: left;
        vertical-align: top;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    th {
        background-color: #eee;
    }

    img {
        max-width: 50px; /* Un poco más pequeño para mantener proporción */
        max-height: 50px;
    }

    .no-break {
        page-break-inside: avoid;
    }
</style>

</head>
<body>
    <h2 style="text-align:center;">Reporte de Partes</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo Registro</th>
                <th>Fecha Recepción</th>
                <th>Ciudad</th>
                <th>Departamento</th>
                <th>Coordenadas</th>
                <th>Tipo Elemento</th>
                <th>Motivo Ingreso</th>
                <th>Institución</th>
                <th>Persona que Recibe</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Tipo Animal</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Disposición Final</th>
                <th>Observaciones</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $partes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($parte->codigo); ?></td>
                    <td><?php echo e(ucfirst(str_replace('_', ' ', $parte->tipo_registro))); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($parte->fecha_recepcion)->format('d/m/Y')); ?></td>
                    <td><?php echo e($parte->ciudad); ?></td>
                    <td><?php echo e($parte->departamento); ?></td>
                    <td><?php echo e($parte->coordenadas); ?></td>
                    <td><?php echo e($parte->tipo_elemento); ?></td>
                    <td><?php echo e($parte->motivo_ingreso); ?></td>
                    <td><?php echo e($parte->institucion_remitente); ?></td>
                    <td><?php echo e($parte->nombre_persona_recibe); ?></td>
                    <td><?php echo e($parte->especie); ?></td>
                    <td><?php echo e($parte->nombre_comun); ?></td>
                    <td><?php echo e($parte->tipo_animal); ?></td>
                    <td><?php echo e($parte->cantidad); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($parte->fecha)->format('d/m/Y')); ?></td>
                    <td><?php echo e($parte->disposicion_final); ?></td>
                    <td><?php echo e($parte->observaciones); ?></td>
                    <td style="text-align:center;">
                        <?php
                            $foto_path = public_path('storage/partes_fotos/' . $parte->foto);
                        ?>
                        <?php if($parte->foto && file_exists($foto_path)): ?>
                            <img src="<?php echo e($foto_path); ?>" alt="Foto">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/partes/report.blade.php ENDPATH**/ ?>