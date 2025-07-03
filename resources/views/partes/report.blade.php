<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Partes</title>
    <style>
    @page {
        size: letter landscape;
        margin: 1cm;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 8px; /* Reducido un poco para que quepa mejor */
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed; /* Fija el ancho de columnas */
        word-wrap: break-word;
    }

    th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: left;
        vertical-align: top;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    th {
        background-color: #eee;
    }

    img {
        max-width: 50px; /* Un poco más pequeño para mantener proporción */
        max-height: 50px;
    }

    .no-break {
        page-break-inside: avoid;
    }
</style>

</head>
<body>
    <h2 style="text-align:center;">Reporte de Partes</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo Registro</th>
                <th>Fecha Recepción</th>
                <th>Ciudad</th>
                <th>Departamento</th>
                <th>Coordenadas</th>
                <th>Tipo Elemento</th>
                <th>Motivo Ingreso</th>
                <th>Institución</th>
                <th>Persona que Recibe</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Tipo Animal</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Disposición Final</th>
                <th>Observaciones</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($partes as $parte)
                <tr>
                    <td>{{ $parte->codigo }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $parte->tipo_registro)) }}</td>
                    <td>{{ \Carbon\Carbon::parse($parte->fecha_recepcion)->format('d/m/Y') }}</td>
                    <td>{{ $parte->ciudad }}</td>
                    <td>{{ $parte->departamento }}</td>
                    <td>{{ $parte->coordenadas }}</td>
                    <td>{{ $parte->tipo_elemento }}</td>
                    <td>{{ $parte->motivo_ingreso }}</td>
                    <td>{{ $parte->institucion_remitente }}</td>
                    <td>{{ $parte->nombre_persona_recibe }}</td>
                    <td>{{ $parte->especie }}</td>
                    <td>{{ $parte->nombre_comun }}</td>
                    <td>{{ $parte->tipo_animal }}</td>
                    <td>{{ $parte->cantidad }}</td>
                    <td>{{ \Carbon\Carbon::parse($parte->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $parte->disposicion_final }}</td>
                    <td>{{ $parte->observaciones }}</td>
                    <td style="text-align:center;">
                        @php
                            $foto_path = public_path('storage/partes_fotos/' . $parte->foto);
                        @endphp
                        @if($parte->foto && file_exists($foto_path))
                            <img src="{{ $foto_path }}" alt="Foto">
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
