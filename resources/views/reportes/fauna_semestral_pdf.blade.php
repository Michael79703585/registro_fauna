<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Semestral</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">INFORME SEMESTRAL</h2>
    <table>
        <tr>
            <td><strong>NOMBRE DEL CDS:</strong> ECOPARQUE LAS GOLONDRINAS</td>
            <td><strong>CATEGORIA:</strong> BIOPARQUE</td>
        </tr>
        <tr>
            <td><strong>GESTION:</strong> {{ $gestion }}</td>
            <td><strong>SEMESTRE:</strong> {{ $semestre }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>CLASE</th>
                <th>ORDEN</th>
                <th>FAMILIA</th>
                <th>NOMBRE CIENTIFICO</th>
                <th>NOMBRE COMUN</th>
                <th># INDIVIDUOS ANTERIOR</th>
                <th>RECEPCIONES</th>
                <th>NACIMIENTOS</th>
                <th>TRANSF. DE UN CDS</th>
                <th>DECESOS</th>
                <th>FUGAS</th>
                <th>TRANSF. A UN CDS</th>
                <th>TOTAL FINAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faunas as $index => $fauna)
                @php
                    $total_entrada = $fauna->recepciones + $fauna->nacimientos + $fauna->transferencias_entrada;
                    $total_salida = $fauna->decesos + $fauna->fugas + $fauna->transferencias_salida;
                    $total_final = $fauna->cantidad_individuos + $total_entrada - $total_salida;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $fauna->clase }}</td>
                    <td>{{ $fauna->orden }}</td>
                    <td>{{ $fauna->familia }}</td>
                    <td>{{ $fauna->nombre_cientifico }}</td>
                    <td>{{ $fauna->nombre_comun }}</td>
                    <td>{{ $fauna->cantidad_individuos }}</td>
                    <td>{{ $fauna->recepciones }}</td>
                    <td>{{ $fauna->nacimientos }}</td>
                    <td>{{ $fauna->transferencias_entrada }}</td>
                    <td>{{ $fauna->decesos }}</td>
                    <td>{{ $fauna->fugas }}</td>
                    <td>{{ $fauna->transferencias_salida }}</td>
                    <td>{{ $total_final }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
