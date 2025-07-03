<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico Filtrado</title>
    <style>
        @page {
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        thead {
            background-color: #2980b9;
            color: white;
            font-weight: 600;
        }
        thead th {
            padding: 8px 10px;
            text-align: center;
            border: 1px solid #1c5980;
        }
        tbody td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            vertical-align: middle;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f7f9fc;
        }
        tbody tr:hover {
            background-color: #d6eaf8;
        }
        p {
            text-align: center;
            color: #666;
            font-style: italic;
            margin-top: 40px;
        }

         tbody td.especie {
    font-style: italic;
  }
    </style>
</head>
<body>
    <h1>Historial Clínico Filtrado</h1>

    @if ($historiales->isEmpty())
        <p>No se encontraron resultados con los filtros aplicados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha de Recepción</th>
                    <th>Departamento</th>
                    <th>Ciudad</th>
                    <th>Tipo de Animal</th>
                    <th>Nombre Común</th>
                    <th>Especie</th>
                    <th>Edad Aparente</th>
                    <th>Sexo</th>
                    <th>Comportamiento</th>
                    <th>Otras Observaciones</th>
                    <th>Fecha (Historial)</th>
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                    <th>Evolución</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiales as $historial)
                    <tr>
                        <td>{{ $historial->fauna->codigo ?? '' }}</td>
                        <td>{{ optional($historial->fauna->created_at)->format('Y-m-d') ?? '' }}</td>
                        <td>{{ $historial->fauna->departamento ?? '' }}</td>
                        <td>{{ $historial->fauna->ciudad ?? '' }}</td>
                        <td>{{ $historial->fauna->tipo_animal ?? '' }}</td>
                        <td>{{ $historial->fauna->nombre_comun ?? '' }}</td>
                        <td class="especie">{{ $historial->fauna->especie ?? '' }}</td>
                        <td>{{ $historial->fauna->edad_aparente ?? '' }}</td>
                        <td>{{ $historial->fauna->sexo ?? '' }}</td>
                        <td>{{ $historial->fauna->comportamiento ?? '' }}</td>
                        <td>{{ $historial->fauna->otras_observaciones ?? '' }}</td>
                        <td>{{ $historial->fecha ? $historial->fecha->format('Y-m-d') : '' }}</td>
                        <td>{{ $historial->diagnostico }}</td>
                        <td>{{ $historial->tratamiento }}</td>
                        <td>{{ $historial->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
