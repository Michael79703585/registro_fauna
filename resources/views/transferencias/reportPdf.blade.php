<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Transferencias de Fauna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background-color: #2980b9;
            color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .estado-pendiente {
            color: #d4ac0d;
            font-weight: bold;
        }
        .estado-aceptado {
            color: #27ae60;
            font-weight: bold;
        }
        .estado-rechazado {
            color: #c0392b;
            font-weight: bold;
        }
        em {
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Reporte de Transferencias de Fauna Silvestre</h1>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo Animal</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Institución Origen</th>
                <th>Institución Destino</th>
                <th>Fecha Transferencia</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transferencias as $t)
                <tr>
                    <td>{{ $t->fauna->codigo ?? 'N/A' }}</td>
                    <td>{{ $t->fauna->tipo_animal ?? 'N/A' }}</td>
                    <td><em>{{ $t->fauna->especie ?? 'N/A' }}</em></td>
                    <td>{{ $t->fauna->nombre_comun ?? 'N/A' }}</td>
                    <td>{{ $t->institucionOrigen->nombre ?? 'N/A' }}</td>
                    <td>{{ $t->institucionDestino->nombre ?? $t->institucion_destino ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->fecha_transferencia)->format('d/m/Y') ?? 'N/A' }}</td>
                    <td>{{ $t->motivo ?? 'N/A' }}</td>
                    <td class="
                        @if($t->estado === 'pendiente') estado-pendiente
                        @elseif($t->estado === 'aceptado') estado-aceptado
                        @elseif($t->estado === 'rechazado') estado-rechazado
                        @else '' @endif
                    ">
                        {{ ucfirst($t->estado ?? 'N/A') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;">No hay transferencias registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
