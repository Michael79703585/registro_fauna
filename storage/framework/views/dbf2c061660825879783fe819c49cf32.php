<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico</title>
    <style>
        @page {
            margin: 100px 40px 80px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        header .title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            text-align: center;
            line-height: 15px;
            color: #555;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 25px;
        }

        .section {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            width: 200px;
            display: inline-block;
        }

        .photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .photo img {
            width: 200px;
            border: 1px solid #ccc;
            padding: 4px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .table th, .table td {
            border: 1px solid #888;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .box {
            border: 1px solid #888;
            padding: 10px;
            margin-bottom: 15px;
        }

        .box-title {
            font-weight: bold;
            background: #f0f0f0;
            padding: 5px 10px;
            border-bottom: 1px solid #888;
        }

        .content {
            padding: 10px;
        }
    </style>
</head>
<body>

<header>
    <div class="title"><?php echo e(Auth::user()->institucion->nombre ?? 'Nombre de Institución'); ?></div>
</header>

<main>
    <h1>Historial Clínico</h1>

    
    <?php if($historial->foto_animal): ?>
        <?php
            $fotoPath = public_path($historial->foto_animal);
        ?>
        <?php if(file_exists($fotoPath)): ?>
            <div class="photo">
                <img src="<?php echo e($fotoPath); ?>" alt="Foto del animal">
            </div>
        <?php endif; ?>
    <?php endif; ?>

    
    <div class="box">
        <div class="box-title">Información General</div>
        <div class="content">
            <p><span class="label">Fecha del Historial:</span> <?php echo e(\Carbon\Carbon::parse($historial->fecha)->format('d/m/Y')); ?></p>
            <p><span class="label">Código del Animal:</span> <?php echo e($historial->fauna->codigo ?? 'N/A'); ?></p>
            <p><span class="label">Fecha de Recepción:</span> <?php echo e($historial->fauna->fecha_recepcion ?? 'N/A'); ?></p>
            <p><span class="label">Departamento:</span> <?php echo e($historial->fauna->departamento ?? 'N/A'); ?></p>
            <p><span class="label">Ciudad:</span> <?php echo e($historial->fauna->ciudad ?? 'N/A'); ?></p>
            <p><span class="label">Tipo de Animal:</span> <?php echo e($historial->fauna->tipo_animal ?? 'N/A'); ?></p>
            <p><span class="label">Nombre Común:</span> <?php echo e($historial->fauna->nombre_comun ?? 'N/A'); ?></p>
            <p><span class="label">Especie:</span> <em><?php echo e($historial->fauna->especie ?? 'N/A'); ?></em></p>
            <p><span class="label">Edad Aparente:</span> <?php echo e($historial->fauna->edad_aparente ?? 'N/A'); ?></p>
            <p><span class="label">Sexo:</span> <?php echo e($historial->fauna->sexo ?? 'N/A'); ?></p>
            <p><span class="label">Comportamiento:</span> <?php echo e($historial->fauna->comportamiento ?? 'N/A'); ?></p>
        </div>
    </div>

    
    <?php
        $examen = is_array($historial->examen_general) ? $historial->examen_general : json_decode($historial->examen_general, true);
        $campos = [
            'condicion_corporal' => 'Condición Corporal',
            'boca' => 'Boca',
            'piel' => 'Piel y Anexos',
            'musculo_esqueletico' => 'Músculo Esquelético',
            'abdomen' => 'Abdomen',
            'frecuencia_cardiaca' => 'Frecuencia Cardíaca',
            'frecuencia_respiratoria' => 'Frecuencia Respiratoria',
            'temperatura' => 'Temperatura',
            'mucosas' => 'Examen de Mucosas',
            'plumas_pico_garras' => 'Plumas, Pico, Garras (Aves)',
            'caparazon_plastrom' => 'Caparazón, Plastrom, Cabeza, Miembros (Reptiles)'
        ];
    ?>

    <div class="box">
        <div class="box-title">Examen General</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Parámetro</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $campos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($label); ?></td>
                        <td><?php echo e($examen[$campo] ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    
    <?php $__currentLoopData = [
        'etologia' => 'Etología',
        'diagnostico' => 'Diagnóstico',
        'tratamiento' => 'Tratamiento',
        'observaciones' => 'Evolución',
        'nutricion' => 'Nutrición',
        'pruebas_laboratorio' => 'Pruebas de Laboratorio',
        'recomendaciones' => 'Recomendaciones'
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($historial->$campo)): ?>
            <div class="box">
                <div class="box-title"><?php echo e($label); ?></div>
                <div class="content"><?php echo e($historial->$campo); ?></div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php if($historial->archivo_laboratorio): ?>
        <?php
            $path = public_path($historial->archivo_laboratorio);
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        ?>

        <div class="box">
            <div class="box-title">Archivo de Laboratorio</div>
            <div class="content">
                <?php if(file_exists($path) && in_array($ext, ['jpg','jpeg','png','webp'])): ?>
                    <img src="<?php echo e($path); ?>" alt="Archivo de laboratorio" style="max-width: 100%; border: 1px solid #ccc;">
                <?php elseif(file_exists($path) && $ext === 'pdf'): ?>
                    <p>Archivo PDF adjunto: <?php echo e(basename($historial->archivo_laboratorio)); ?></p>
                <?php else: ?>
                    <p>No se puede previsualizar este tipo de archivo. Verifique el formato.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</main>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/historial/pdf.blade.php ENDPATH**/ ?>