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
                <td>{{ $historial->fauna->especie ?? '' }}</td>
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
