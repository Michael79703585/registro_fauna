<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de <?php echo e(ucfirst($evento->tipoEvento->nombre)); ?> <?php echo e($evento->codigo); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 30px;
        }

        .container {
            border: 2px solid #002060;
            padding: 20px;
            border-radius: 10px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 6px;
        }

        .label {
            font-weight: bold;
            text-transform: uppercase;
            color: #002060;
            font-size: 11px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            background-color: #f9f9f9;
            min-height: 20px;
            font-size: 12px;
        }

        .photo {
            text-align: center;
            padding: 10px;
        }

        .photo img {
            max-width: 220px;
            height: auto;
            border: 1px solid #333;
            border-radius: 8px;
        }

        .section-title {
            font-weight: bold;
            color: #002060;
            border-top: 1px solid #ccc;
            margin-top: 15px;
            padding-top: 10px;
        }

        .yellow { background-color: #ffffcc; }
        .gray { background-color: #e0e0e0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Registro de <?php echo e(ucfirst($evento->tipoEvento->nombre)); ?></div>

        <table>
            <tr>
                <td width="50%">
                    <span class="label">Institución</span>
                    <div class="box yellow"><?php echo e($evento->institucion?->nombre ?? 'N/A'); ?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Fecha del Evento</span>
                    <div class="box"><?php echo e(\Carbon\Carbon::parse($evento->fecha)->format('d/m/Y')); ?></div>
                </td>
                <td>
                    <span class="label">Código Asignado</span>
                    <div class="box"><?php echo e($evento->codigo); ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Tipo de Evento</span>
                    <div class="box"><?php echo e($evento->tipoEvento->nombre); ?></div>
                </td>
            </tr>

            
            <?php $tipo = strtolower($evento->tipoEvento->nombre); ?>

            <?php if($tipo === 'nacimiento'): ?>
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td width="40%" class="photo">
                                <span class="label">Fotografía del Individuo</span><br><br>
                                <?php if($evento->foto): ?>
                                    <img src="<?php echo e(public_path('storage/' . $evento->foto)); ?>" alt="Foto del evento">
                                <?php else: ?>
                                    <div style="border: 1px dashed #aaa; padding: 40px; border-radius: 10px;">
                                        Sin fotografía
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td width="60%">
                                <span class="label">Nombre Común</span>
                                <div class="box"><?php echo e($evento->nombre_comun ?? 'N/A'); ?></div>

                                <span class="label">Especie</span>
                                <div class="box" style="font-style: italic;"><?php echo e($evento->especie ?? 'N/A'); ?></div>


                                <span class="label">Sexo</span>
                                <div class="box gray"><?php echo e($evento->sexo ?? 'N/A'); ?></div>

                                <span class="label">Código de los Padres</span>
                                <div class="box"><?php echo e($evento->codigo_padres ?? 'N/A'); ?></div>

                                <span class="label">Señas Particulares</span>
                                <div class="box"><?php echo e($evento->senas_particulares ?? 'N/A'); ?></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <?php elseif($tipo === 'deceso'): ?>
            <tr>
                <td colspan="2">
                    <span class="label">Nombre Común</span>
                    <div class="box"><?php echo e($evento->nombre_comun ?? 'N/A'); ?></div>

                    <span class="label">Especie</span>
                    <div class="box" style="font-style: italic;"><?php echo e($evento->especie ?? 'N/A'); ?></div>


                    <span class="label">Causas del Deceso</span>
                    <div class="box"><?php echo e($evento->causas_deceso ?? 'N/A'); ?></div>

                    <div class="photo">
                        <?php if($evento->foto): ?>
                            <span class="label">Fotografía del Evento</span><br><br>
                            <img src="<?php echo e(public_path('storage/' . $evento->foto)); ?>" alt="Foto del evento">
                        <?php endif; ?>
                    </div>
                </td>
            </tr>

            <?php elseif($tipo === 'fuga'): ?>
            <tr>
                <td colspan="2">
                    <span class="label">Código del Animal</span>
                    <div class="box"><?php echo e($evento->codigo_animal ?? 'N/A'); ?></div>

                    <span class="label">Nombre Común</span>
                    <div class="box"><?php echo e($evento->nombre_comun ?? 'N/A'); ?></div>

                    <span class="label">Especie</span>
                    <div class="box" style="font-style: italic;"><?php echo e($evento->especie ?? 'N/A'); ?></div>


                    <span class="label">Sexo</span>
                    <div class="box"><?php echo e($evento->sexo ?? 'N/A'); ?></div>

                    <span class="label">Fecha de Fuga</span>
                    <div class="box">
                        <?php echo e($evento->fecha ? \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') : 'N/A'); ?>

                    </div>

                    <span class="label">Descripción de la Fuga</span>
                    <div class="box">
                        <?php echo nl2br(e($evento->descripcion_fuga ?? 'N/A')); ?>

                    </div>

                    <div class="photo">
                        <?php if($evento->foto): ?>
                            <span class="label">Fotografía del Evento</span><br><br>
                            <img src="<?php echo e(public_path('storage/' . $evento->foto)); ?>" alt="Foto del evento">
                        <?php else: ?>
                            <div style="border: 1px dashed #aaa; padding: 40px; border-radius: 10px;">
                                Sin fotografía
                            </div>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endif; ?>

            
            <tr>
                <td colspan="2">
                    <div class="section-title">Observaciones</div>
                    <div class="box"><?php echo e($evento->observaciones ?? 'Sin observaciones'); ?></div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\registro_fauna\resources\views/eventos/reporte_evento_pdf.blade.php ENDPATH**/ ?>