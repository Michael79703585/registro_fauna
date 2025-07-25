<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General de Fauna</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
            margin: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Fuerza a que las columnas se ajusten */
            word-wrap: break-word;
        }

        th, td {
            border: 1px solid #333;
            padding: 3px;
            vertical-align: top;
            overflow-wrap: break-word;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Reporte General de Fauna</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha Recepción</th>
                <th>Ciudad</th>
                <th>Departamento</th>
                <th>Tipo Elemento</th>
                <th>Motivo Ingreso</th>
                <th>Lugar</th>
                <th>Institución Responsable</th>
                <th>Nombre Persona Recibe</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Tipo Animal</th>
                <th>Edad Aparente</th>
                <th>Estado General</th>
                <th>Sexo</th>
                <th>Sospecha Enfermedad</th>
                <th>Descripción Enfermedad</th>
                <th>Alteraciones Evidentes</th>
                <th>Tiempo Cautiverio</th>
                <th>Tipo Alimentación</th>
                <th>Derivación CCFS</th>
                <th>Descripción Derivación</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $faunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fauna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($fauna->codigo); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($fauna->fecha_recepcion)->format('d/m/Y')); ?></td>
                    <td><?php echo e($fauna->ciudad); ?></td>
                    <td><?php echo e($fauna->departamento); ?></td>
                    <td><?php echo e($fauna->tipo_elemento); ?></td>
                    <td><?php echo e($fauna->motivo_ingreso); ?></td>
                    <td><?php echo e($fauna->lugar); ?></td>
                    <td><?php echo e($fauna->institucion_remitente); ?></td>
                    <td><?php echo e($fauna->nombre_persona_recibe); ?></td>
                    <td><?php echo e($fauna->especie); ?></td>
                    <td><?php echo e($fauna->nombre_comun); ?></td>
                    <td><?php echo e($fauna->tipo_animal); ?></td>
                    <td><?php echo e($fauna->edad_aparente); ?></td>
                    <td><?php echo e($fauna->estado_general); ?></td>
                    <td><?php echo e($fauna->sexo); ?></td>
                    <td><?php echo e($fauna->sospecha_enfermedad ? 'SI' : 'NO'); ?></td>
                    <td><?php echo e($fauna->descripcion_enfermedad); ?></td>
                    <td><?php echo e($fauna->alteraciones_evidentes); ?></td>
                    <td><?php echo e($fauna->tiempo_cautiverio); ?></td>
                    <td><?php echo e($fauna->tipo_alimentacion); ?></td>
                    <td><?php echo e($fauna->derivacion_ccfs ? 'SI' : 'NO'); ?></td>
                    <td><?php echo e($fauna->descripcion_derivacion); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/fauna/reportepdf.blade.php ENDPATH**/ ?>