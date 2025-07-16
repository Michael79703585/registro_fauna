<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5">
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
                    <td>{{ $evento->especie ?? $evento->fauna->especie ?? '-' }}</td>
                    <td>{{ $evento->nombre_comun ?? $evento->fauna->nombre_comun ?? '-' }}</td>
                    <td>{{ $evento->sexo ?? $evento->fauna->sexo ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $evento->institucion->nombre ?? '-' }}</td>
                    <td>{{ $evento->observaciones ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
