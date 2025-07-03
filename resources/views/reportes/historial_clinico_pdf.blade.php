<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Historial Clínico</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Reporte de Historial Clínico</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fauna</th>
                <th>Fecha</th>
                <th>Diagnóstico</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($historial as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fauna->nombre_comun ?? 'N/A' }}</td>
                    <td>{{ $item->fecha->format('d/m/Y') }}</td>
                    <td>{{ $item->diagnostico }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No hay registros disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
