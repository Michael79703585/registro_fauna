<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exportación PDF - Liberaciones</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; }
        img { max-width: 60px; max-height: 60px; object-fit: cover; }
        .italic { font-style: italic; }
    </style>
</head>
<body>
    <h2>Listado de Liberaciones</h2>

    <table>
        <thead>
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Lugar</th>
            <th>Departamento</th>
            <th>Municipio</th>
            <th>Coordenadas</th>
            <th>Tipo Animal</th>
            <th>Especie</th>
            <th>Nombre Común</th>
            <th>Responsable</th>
            <th>Institución</th>
            <th>Observaciones</th>
            <th>Foto</th>
        </tr>
        </thead>
        <tbody>
        @foreach($liberaciones as $lib)
            <tr>
                <td>{{ $lib->codigo }}</td>
                <td>{{ \Carbon\Carbon::parse($lib->fecha)->format('d/m/Y') }}</td>
                <td>{{ $lib->lugar_liberacion }}</td>
                <td>{{ $lib->departamento }}</td>
                <td>{{ $lib->municipio }}</td>
                <td>{{ $lib->coordenadas }}</td>
                <td>{{ $lib->tipo_animal }}</td>
                <td class="italic">{{ $lib->especie }}</td>
                <td>{{ $lib->nombre_comun }}</td>
                <td>{{ $lib->responsable }}</td>
                <td>{{ $lib->institucion }}</td>
                <td>{{ $lib->observaciones }}</td>
                <td>
                    @if ($lib->foto)
                        <img src="{{ public_path('storage/' . $lib->foto) }}" alt="Foto">
                    @else
                        Sin foto
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
