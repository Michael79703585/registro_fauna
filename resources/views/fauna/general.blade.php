<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
    <title>Reporte General de Fauna</title>
</head>
<body>
    <h2>Reporte General de Fauna Registrada</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Especie</th>
                <th>Fecha</th>
                <th>Sexo</th>
                <th>Procedencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faunas as $fauna)
            <tr>
                <td>{{ $fauna->codigo }}</td>
                <td>{{ $fauna->especie }}</td>
                <td>{{ $fauna->fecha_ingreso }}</td>
                <td>{{ $fauna->sexo }}</td>
                <td>{{ $fauna->procedencia }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
