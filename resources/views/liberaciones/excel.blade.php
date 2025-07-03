<table>
    <thead>
    <tr>
        <th>Código</th>
        <th>Fecha</th>
        <th>Lugar</th>
        <th>Departamento</th>
        <th>Municipio</th>
        <th>Especie</th>
        <th>Cantidad</th>
        <th>Responsable</th>
    </tr>
    </thead>
    <tbody>
    @foreach($liberaciones as $lib)
        <tr>
            <td>{{ $lib->codigo }}</td>
            <td>{{ \Carbon\Carbon::parse($lib->fecha)->format('d/m/Y') }}</td>
            <td>{{ $lib->lugar }}</td>
            <td>{{ $lib->departamento }}</td>
            <td>{{ $lib->municipio }}</td>
            <td>{{ $lib->especie }}</td>
            <td>{{ $lib->cantidad }}</td>
            <td>{{ $lib->responsable }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
