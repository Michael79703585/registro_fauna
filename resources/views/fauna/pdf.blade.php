<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Fauna</title>
    <style>
        @page {
            size: letter landscape;
            margin: 1cm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px; /* reducido para que entre más contenido */
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            margin-bottom: 4px;
        }

        td, th {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: top; /* CORREGIDO: era "horizontal-align", ahora está bien */
        }

        img {
            max-width: 180px;
            max-height: 180px;
        }

        p {
            margin: 2px 0;
            font-size: 10px;
        }
    </style>
</head>

<h2>FORMULARIO ÚNICO DE REGISTRO DE FAUNA SILVESTRE</h2>

<table>
    <tr>
        <td colspan="2"><span class="bold">Fecha de recepción:</span> {{ $fauna->fecha_recepcion }}</td>
        <td><span class="bold">Ciudad:</span> {{ $fauna->ciudad }}</td>
        <td><span class="bold">Departamento:</span> {{ $fauna->departamento }}</td>
        <td><span class="bold">Coordenadas:</span> {{ $fauna->coordenadas }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Tipo de elemento:</span> {{ $fauna->tipo_elemento }}</td>
    </tr>
    <tr>
        <td><span class="bold">Entrega voluntaria:</span> {{ $fauna->motivo_ingreso === 'Entrega voluntaria' ? '✔' : '' }}</td>
        <td><span class="bold">Decomiso:</span> {{ $fauna->motivo_ingreso === 'Decomiso' ? '✔' : '' }}</td>
        <td><span class="bold">Rescate:</span> {{ $fauna->motivo_ingreso === 'Rescate' ? '✔' : '' }}</td>
        <td><span class="bold">Captura:</span> {{ $fauna->motivo_ingreso === 'Captura' ? '✔' : '' }}</td>
        <td><span class="bold">Otro:</span> {{ $fauna->motivo_ingreso !== 'Entrega voluntaria' && $fauna->motivo_ingreso !== 'Decomiso' && $fauna->motivo_ingreso !== 'Rescate' && $fauna->motivo_ingreso !== 'Captura' ? '✔ ' . $fauna->motivo_ingreso : '' }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Lugar:</span> {{ $fauna->lugar }}</td>
    </tr>
    <tr>
        <td colspan="3"><span class="bold">Institución remitente:</span> {{ $fauna->institucion_remitente }}</td>
        <td colspan="2"><span class="bold">Persona que recibe:</span> {{ $fauna->nombre_persona_recibe }}</td>
    </tr>
</table>

@if($fauna->foto)
    <p><strong>FOTOGRAFÍA DE LA ESPECIE/PARTE O DERIVADO</strong></p>
    <img src="{{ public_path('storage/' . $fauna->foto) }}" style="max-width: 200px; max-height: 200px;">
@endif

<table>
    <tr><td colspan="5"><span class="bold">CÓDIGO ASIGNADO:</span> {{ $fauna->codigo }}</td></tr>
    <tr>
        <td colspan="3"><span class="bold">Especie:</span> {{ $fauna->especie }}</td>
        <td colspan="2"><span class="bold">Nombre común:</span> {{ $fauna->nombre_comun }}</td>
    </tr>
    <tr>
        <td><span class="bold">Mamífero:</span> {{ $fauna->tipo_animal === 'Mamífero' ? '✔' : '' }}</td>
        <td><span class="bold">Ave:</span> {{ $fauna->tipo_animal === 'Ave' ? '✔' : '' }}</td>
        <td><span class="bold">Reptil:</span> {{ $fauna->tipo_animal === 'Reptil' ? '✔' : '' }}</td>
        <td><span class="bold">Anfibio:</span> {{ $fauna->tipo_animal === 'Anfibio' ? '✔' : '' }}</td>
        <td><span class="bold">Otro:</span> {{ !in_array($fauna->tipo_animal, ['Mamífero', 'Ave', 'Reptil', 'Anfibio']) ? '✔ ' . $fauna->tipo_animal : '' }}</td>
    </tr>
    <tr>
        <td><span class="bold">Neonato:</span> {{ $fauna->edad_aparente === 'Neonato' ? '✔' : '' }}</td>
        <td><span class="bold">Juvenil:</span> {{ $fauna->edad_aparente === 'Juvenil' ? '✔' : '' }}</td>
        <td><span class="bold">Adulto:</span> {{ $fauna->edad_aparente === 'Adulto' ? '✔' : '' }}</td>
        <td><span class="bold">Geriátrico:</span> {{ $fauna->edad_aparente === 'Geriátrico' ? '✔' : '' }}</td>
        <td></td>
    </tr>
    <tr>
        <td><span class="bold">Aparentemente normal:</span> {{ $fauna->estado_general === 'Aparentemente normal' ? '✔' : '' }}</td>
        <td><span class="bold">Herido:</span> {{ $fauna->estado_general === 'Herido' ? '✔' : '' }}</td>
        <td><span class="bold">Enfermo:</span> {{ $fauna->estado_general === 'Enfermo' ? '✔' : '' }}</td>
        <td><span class="bold">Muerto:</span> {{ $fauna->estado_general === 'Muerto' ? '✔' : '' }}</td>
        <td></td>
    </tr>
    <tr>
        <td><span class="bold">Hembra:</span> {{ $fauna->sexo === 'Hembra' ? '✔' : '' }}</td>
        <td><span class="bold">Macho:</span> {{ $fauna->sexo === 'Macho' ? '✔' : '' }}</td>
        <td><span class="bold">Indeterminado:</span> {{ $fauna->sexo === 'Indeterminado' ? '✔' : '' }}</td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td><span class="bold">Aparentemente normal:</span> {{ $fauna->comportamiento === 'Aparentemente normal' ? '✔' : '' }}</td>
        <td><span class="bold">Tímido:</span> {{ $fauna->comportamiento === 'Tímido' ? '✔' : '' }}</td>
        <td><span class="bold">Agresivo:</span> {{ $fauna->comportamiento === 'Agresivo' ? '✔' : '' }}</td>
        <td><span class="bold">Otro:</span> {{ !in_array($fauna->comportamiento, ['Aparentemente normal', 'Tímido', 'Agresivo']) ? '✔ ' . $fauna->comportamiento : '' }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><span class="bold">Sospecha de enfermedad al momento del rescate:</span> {{ $fauna->sospecha_enfermedad ? 'SI' : 'NO' }}</td>
        <td colspan="3"><span class="bold">Describa:</span> {{ $fauna->descripcion_enfermedad }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Alteraciones evidentes (Heridas, fractura, etc.):</span> {{ $fauna->alteraciones_evidentes }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Otras observaciones:</span> {{ $fauna->otras_observaciones }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Tiempo aproximado de cautiverio:</span> {{ $fauna->tiempo_cautiverio }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Tipo de alojamiento:</span> {{ $fauna->tipo_alojamiento }}</td>
    </tr>
    <tr>
        <td><span class="bold">Contacto con otros animales/humanos:</span> {{ $fauna->contacto_con_animales ? 'SI' : 'NO' }}</td>
        <td colspan="4"><span class="bold">Especies / Describa:</span> {{ $fauna->descripcion_contacto }}</td>
    </tr>
    <tr>
        <td><span class="bold">Padeció alguna enfermedad:</span> {{ $fauna->padecio_enfermedad ? 'SI' : 'NO' }}</td>
        <td colspan="4"><span class="bold">Describa:</span> {{ $fauna->descripcion_padecimiento }}</td>
    </tr>
    <tr>
        <td colspan="5"><span class="bold">Describa tipo de alimentación que recibía:</span> {{ $fauna->tipo_alimentacion }}</td>
    </tr>
    <tr>
        <td><span class="bold">Derivación a un CCFS:</span> {{ $fauna->derivacion_ccfs ? 'SI' : 'NO' }}</td>
        <td colspan="4"><span class="bold">Detalle el nombre del CCFS:</span> {{ $fauna->descripcion_derivacion }}</td>
    </tr>
</table>

</body>
</html>