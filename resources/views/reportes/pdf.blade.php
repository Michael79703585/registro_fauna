<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Fauna #{{ $reporte->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #34495e;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        .text-left {
            text-align: left;
        }
        .small {
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <h1>Reporte Fauna #{{ $reporte->id }}</h1>
    <h2>{{ $reporte->tipo ?? 'N/A' }}</h2>

    <p><strong>Institución:</strong> {{ $reporte->institucion->nombre ?? 'N/A' }}</p>
    <p><strong>Fecha inicio:</strong> {{ \Carbon\Carbon::parse($reporte->fecha_inicio)->format('d/m/Y') ?? '-' }}</p>
    <p><strong>Fecha fin:</strong> {{ \Carbon\Carbon::parse($reporte->fecha_fin)->format('d/m/Y') ?? '-' }}</p>

    {{-- Tabla con fauna --}}
    @if($faunas->count())
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Común</th>
                <th>Nombre Científico</th>
                <th>Tipo Animal</th>
                <th>Fecha Recepción</th>
                <th>Estado</th>
                <th>Comentarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faunas as $fauna)
            <tr>
                <td>{{ $fauna->id }}</td>
                <td class="text-left">{{ $fauna->nombre_comun ?? '-' }}</td>
                <td class="text-left"><em>{{ $fauna->nombre_cientifico ?? '-' }}</em></td>
                <td>{{ $fauna->tipo_animal ?? '-' }}</td>
                <td>{{ $fauna->fecha_recepcion ? \Carbon\Carbon::parse($fauna->fecha_recepcion)->format('d/m/Y') : '-' }}</td>
                <td>{{ $fauna->estado ?? '-' }}</td>
                <td class="text-left">{{ $fauna->comentarios ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No hay registros de fauna para este reporte.</p>
    @endif
</body>
</html>
