<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Historial de {{ $fauna->codigo }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 40px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        h3 {
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .section {
            margin-bottom: 30px;
        }

        .label {
            font-weight: bold;
            width: 200px;
            display: inline-block;
            color: #000;
        }

        .record {
            background-color: #f9f9f9;
            border-left: 4px solid #2980b9;
            padding: 10px;
            margin-bottom: 12px;
        }

        img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 4px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <h1>RECEPCION DE FAUNA</h1>

    <div class="section">
        <p><span class="label">Código:</span> {{ $fauna->codigo }}</p>
        <p><span class="label">Especie:</span> {{ $fauna->especie }}</p>
        <p><span class="label">Fecha de ingreso:</span> {{ $fauna->fecha_ingreso }}</p>
        <p><span class="label">Institución de origen:</span> {{ $fauna->user->institucion->nombre ?? 'N/A' }}</p>
        <p><span class="label">Registrado por:</span> {{ $fauna->user->name }}</p>
    </div>

    @if($fauna->historialesClinicos && $fauna->historialesClinicos->count())
        <div class="section">
            <h3>Historial Clínico</h3>
            @foreach($fauna->historialesClinicos as $hc)
                <div class="record">
                    <p><strong>Fecha:</strong> {{ $hc->created_at->format('d/m/Y') }}</p>
                    <p>{!! nl2br(e($hc->contenido)) !!}</p>
                </div>
            @endforeach
        </div>
    @endif

    @if($fotoPath)
        <div class="section">
            <h3>Fotografía</h3>
            <img src="{{ $fotoPath }}" alt="Foto del animal">
        </div>
    @endif

</body>
</html>
