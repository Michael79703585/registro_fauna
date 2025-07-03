<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General de Fauna</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
            margin: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Fuerza a que las columnas se ajusten */
            word-wrap: break-word;
        }

        th, td {
            border: 1px solid #333;
            padding: 3px;
            vertical-align: top;
            overflow-wrap: break-word;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Reporte General de Fauna</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha Recepción</th>
                <th>Ciudad</th>
                <th>Departamento</th>
                <th>Tipo Elemento</th>
                <th>Motivo Ingreso</th>
                <th>Lugar</th>
                <th>Institución Responsable</th>
                <th>Nombre Persona Recibe</th>
                <th>Especie</th>
                <th>Nombre Común</th>
                <th>Tipo Animal</th>
                <th>Edad Aparente</th>
                <th>Estado General</th>
                <th>Sexo</th>
                <th>Sospecha Enfermedad</th>
                <th>Descripción Enfermedad</th>
                <th>Alteraciones Evidentes</th>
                <th>Tiempo Cautiverio</th>
                <th>Tipo Alimentación</th>
                <th>Derivación CCFS</th>
                <th>Descripción Derivación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faunas as $fauna)
                <tr>
                    <td>{{ $fauna->codigo }}</td>
                    <td>{{ \Carbon\Carbon::parse($fauna->fecha_recepcion)->format('d/m/Y') }}</td>
                    <td>{{ $fauna->ciudad }}</td>
                    <td>{{ $fauna->departamento }}</td>
                    <td>{{ $fauna->tipo_elemento }}</td>
                    <td>{{ $fauna->motivo_ingreso }}</td>
                    <td>{{ $fauna->lugar }}</td>
                    <td>{{ $fauna->institucion_remitente }}</td>
                    <td>{{ $fauna->nombre_persona_recibe }}</td>
                    <td>{{ $fauna->especie }}</td>
                    <td>{{ $fauna->nombre_comun }}</td>
                    <td>{{ $fauna->tipo_animal }}</td>
                    <td>{{ $fauna->edad_aparente }}</td>
                    <td>{{ $fauna->estado_general }}</td>
                    <td>{{ $fauna->sexo }}</td>
                    <td>{{ $fauna->sospecha_enfermedad ? 'SI' : 'NO' }}</td>
                    <td>{{ $fauna->descripcion_enfermedad }}</td>
                    <td>{{ $fauna->alteraciones_evidentes }}</td>
                    <td>{{ $fauna->tiempo_cautiverio }}</td>
                    <td>{{ $fauna->tipo_alimentacion }}</td>
                    <td>{{ $fauna->derivacion_ccfs ? 'SI' : 'NO' }}</td>
                    <td>{{ $fauna->descripcion_derivacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
