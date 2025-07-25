<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Parte</title>
    <style>
        @page {
            size: letter landscape;
            margin: 1cm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2 {
            text-align: center;
            font-size: 14px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            table-layout: fixed;
            word-wrap: break-word;
        }

        td, th {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: top;
        }

        p {
            margin: 4px 0;
        }

        .foto {
            text-align: center;
            margin-top: 10px;
        }

        .foto img {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>
<body>

<h2>FORMULARIO DE REGISTRO DE PARTES / DERIVADOS</h2>

<table>
    <tr>
        <td colspan="2"><span class="bold">Fecha de recepción:</span> <?php echo e($parte->fecha_recepcion); ?></td>
        <td><span class="bold">Ciudad:</span> <?php echo e($parte->ciudad); ?></td>
        <td><span class="bold">Departamento:</span> <?php echo e($parte->departamento); ?></td>
        <td><span class="bold">Coordenadas:</span> <?php echo e($parte->coordenadas); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Tipo de elemento:</span> <?php echo e($parte->tipo_elemento); ?></td>
    </tr>
    <tr>
        <td><span class="bold">Entrega voluntaria:</span> <?php echo e($parte->motivo_ingreso === 'Entrega voluntaria' ? '✔' : ''); ?></td>
        <td><span class="bold">Decomiso:</span> <?php echo e($parte->motivo_ingreso === 'Decomiso' ? '✔' : ''); ?></td>
        <td><span class="bold">Rescate:</span> <?php echo e($parte->motivo_ingreso === 'Rescate' ? '✔' : ''); ?></td>
        <td><span class="bold">Captura:</span> <?php echo e($parte->motivo_ingreso === 'Captura' ? '✔' : ''); ?></td>
        <td><span class="bold">Otro:</span> <?php echo e(!in_array($parte->motivo_ingreso, ['Entrega voluntaria','Decomiso','Rescate','Captura']) ? '✔ ' . $parte->motivo_ingreso : ''); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Institución:</span> <?php echo e($parte->institucion_remitente); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Persona que recibe:</span> <?php echo e($parte->nombre_persona_recibe); ?></td>
    </tr>
</table>


<div class="foto">
    <p><strong>Fotografía:</strong></p>
    <?php if($parte->foto && file_exists(public_path('storage/partes_fotos/' . $parte->foto))): ?>
    <img src="<?php echo e(public_path('storage/partes_fotos/' . $parte->foto)); ?>" alt="Foto" style="max-width:200px; max-height:200px;">
<?php else: ?>
    <p>Foto no disponible</p>
<?php endif; ?>
</div>

<table>
    <tr><td colspan="5"><span class="bold">CÓDIGO ASIGNADO:</span> <?php echo e($parte->codigo); ?></td></tr>
    <tr>
        <td colspan="3"><span class="bold">Especie:</span> <?php echo e($parte->especie); ?></td>
        <td colspan="2"><span class="bold">Nombre común:</span> <?php echo e($parte->nombre_comun); ?></td>
    </tr>
    <tr>
        <td><span class="bold">Mamífero:</span> <?php echo e($parte->tipo_animal === 'Mamífero' ? '✔' : ''); ?></td>
        <td><span class="bold">Ave:</span> <?php echo e($parte->tipo_animal === 'Ave' ? '✔' : ''); ?></td>
        <td><span class="bold">Reptil:</span> <?php echo e($parte->tipo_animal === 'Reptil' ? '✔' : ''); ?></td>
        <td><span class="bold">Anfibio:</span> <?php echo e($parte->tipo_animal === 'Anfibio' ? '✔' : ''); ?></td>
        <td><span class="bold">Otro:</span> <?php echo e(!in_array($parte->tipo_animal, ['Mamífero','Ave','Reptil','Anfibio']) ? '✔ ' . $parte->tipo_animal : ''); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Cantidad:</span> <?php echo e($parte->cantidad); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Tipo de registro:</span> <?php echo e(ucfirst(str_replace('_', ' ', $parte->tipo_registro))); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Disposición final:</span> <?php echo e($parte->disposicion_final); ?></td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Observaciones:</span> <?php echo e($parte->observaciones); ?></td>
    </tr>
</table>

</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/partes/pdf_individual.blade.php ENDPATH**/ ?>