<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Tipo Animal</th>
            <th>Especie</th>
            <th>Nombre Común</th>
            <th>Institución Origen</th>
            <th>Institución Destino</th>
            <th>Fecha Transferencia</th>
            <th>Motivo</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transferencias as $t)
            <tr>
                <td>{{ $t->fauna->codigo ?? 'N/A' }}</td>
                <td>{{ $t->fauna->tipo_animal ?? 'N/A' }}</td>
                <td>{{ $t->fauna->especie ?? 'N/A' }}</td>
                <td>{{ $t->fauna->nombre_comun ?? 'N/A' }}</td>
                <td>{{ $t->institucionOrigen->nombre ?? 'N/A' }}</td>
                <td>{{ $t->institucionDestino->nombre ?? $t->institucion_destino ?? 'N/A' }}</td>
                <td>{{ $t->fecha_transferencia ? \Carbon\Carbon::parse($t->fecha_transferencia)->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $t->motivo ?? 'N/A' }}</td>
                <td>{{ ucfirst($t->estado ?? 'N/A') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
