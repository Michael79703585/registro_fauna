<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transferencia #<?php echo e($transferencia->id); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            font-size: 22px;
            margin-bottom: 30px;
        }

        .content {
            margin: 0 auto;
            width: 90%;
        }

        .field {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            width: 220px;
            display: inline-block;
        }

        .text-block {
            margin-top: 40px;
            font-size: 14px;
            line-height: 1.6;
            text-align: justify;
        }

        .signature-section {
            margin-top: 60px;
            text-align: center;
        }

        .line {
            margin: 40px auto 10px;
            width: 300px;
            border-top: 1px solid #000;
        }

        .signature-text {
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <h1>TRANSFERENCIA DE FAUNA SILVESTRE</h1>

<div class="content">
    <div class="field">
        <span class="label">Código:</span>
        <?php echo e($transferencia->fauna->codigo ?? 'N/A'); ?>

    </div>
     <div class="field">
        <span class="label">Tipo de Animal:</span>
        <?php echo e($transferencia->fauna->tipo_animal ?? 'N/A'); ?>

    </div>
    <div class="field">
        <span class="label">Especie:</span>
        <em><?php echo e($transferencia->fauna->especie ?? 'N/A'); ?></em>
    </div>

    <div class="field">
        <span class="label">Nombre Común:</span>
        <?php echo e($transferencia->fauna->nombre_comun ?? 'N/A'); ?>

    </div>
    <div class="field">
        <span class="label">Fecha de Transferencia:</span>
        <?php echo e($transferencia->fecha_transferencia); ?>

    </div>
    <div class="field">
        <span class="label">Institución Origen:</span>
        <?php echo e($transferencia->institucionOrigen->nombre ?? 'N/A'); ?>

    </div>
    <div class="field">
        <span class="label">Institución Destino:</span>
        <?php echo e($transferencia->institucionDestino->nombre ?? $transferencia->institucion_destino); ?>

    </div>
    <div class="field">
        <span class="label">Motivo:</span>
        <?php echo e($transferencia->motivo); ?>

    </div>
    <div class="field">
        <span class="label">Observaciones:</span>
        <?php echo e($transferencia->observaciones); ?>

    </div>
</div>


    <div class="text-block">
        La institución en adelante se encargará de la custodia y el cuidado para fines legales consiguientes hasta que la Autoridad Ambiental Competente así lo determine.
    </div>

    <div class="signature-section">
        <div class="line"></div>
        <div class="signature-text">Firma Responsable de Entrega</div>

        <div class="line" style="margin-top: 60px;"></div>
        <div class="signature-text">Firma Responsable de Recepción</div>
    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/transferencias/pdf.blade.php ENDPATH**/ ?>