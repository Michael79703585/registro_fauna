<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Transferencias</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eaeaea; }
    </style>
</head>
<body>
    <h1>Reporte de Transferencias</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fauna</th>
                <th>Institución Destino</th>
                <th>Motivo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transferencias as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fauna->nombre_comun ?? 'N/A' }}</td>
                    <td>{{ $item->institucion_destino }}</td>
                    <td>{{ $item->motivo }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->fecha_transferencia)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No se encontraron transferencias.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
