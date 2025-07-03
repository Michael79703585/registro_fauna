<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo de Evento</th>
                <th>Código Animal</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Sexo</th>
                <th>Fecha</th>
                <th>Institución</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $i => $evento)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $evento->tipoEvento->nombre ?? '-' }}</td>
                    <td>{{ $evento->codigo ?? '-' }}</td>
                    <td>{{ $evento->especie ?? '-' }}</td>
                    <td>{{ $evento->nombre_comun ?? '-' }}</td>
                    <td>{{ $evento->sexo ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $evento->institucion->nombre ?? '-' }}</td>
                    <td>{{ $evento->observaciones ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
