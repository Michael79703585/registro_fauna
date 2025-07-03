<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de {{ ucfirst($evento->tipoEvento->nombre) }} {{ $evento->codigo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 30px;
        }

        .container {
            border: 2px solid #002060;
            padding: 20px;
            border-radius: 10px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 6px;
        }

        .label {
            font-weight: bold;
            text-transform: uppercase;
            color: #002060;
            font-size: 11px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            background-color: #f9f9f9;
            min-height: 20px;
            font-size: 12px;
        }

        .photo {
            text-align: center;
            padding: 10px;
        }

        .photo img {
            max-width: 220px;
            height: auto;
            border: 1px solid #333;
            border-radius: 8px;
        }

        .section-title {
            font-weight: bold;
            color: #002060;
            border-top: 1px solid #ccc;
            margin-top: 15px;
            padding-top: 10px;
        }

        .yellow { background-color: #ffffcc; }
        .gray { background-color: #e0e0e0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Registro de {{ ucfirst($evento->tipoEvento->nombre) }}</div>

        <table>
            <tr>
                <td width="50%">
                    <span class="label">Institución</span>
                    <div class="box yellow">{{ $evento->institucion?->nombre ?? 'N/A' }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Fecha del Evento</span>
                    <div class="box">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</div>
                </td>
                <td>
                    <span class="label">Código Asignado</span>
                    <div class="box">{{ $evento->codigo }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Tipo de Evento</span>
                    <div class="box">{{ $evento->tipoEvento->nombre }}</div>
                </td>
            </tr>

            {{-- Contenido específico por tipo --}}
            @php $tipo = strtolower($evento->tipoEvento->nombre); @endphp

            @if ($tipo === 'nacimiento')
            <tr>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td width="40%" class="photo">
                                <span class="label">Fotografía del Individuo</span><br><br>
                                @if ($evento->foto)
                                    <img src="{{ public_path('storage/' . $evento->foto) }}" alt="Foto del evento">
                                @else
                                    <div style="border: 1px dashed #aaa; padding: 40px; border-radius: 10px;">
                                        Sin fotografía
                                    </div>
                                @endif
                            </td>
                            <td width="60%">
                                <span class="label">Nombre Común</span>
                                <div class="box">{{ $evento->nombre_comun ?? 'N/A' }}</div>

                                <span class="label">Especie</span>
                                <div class="box" style="font-style: italic;">{{ $evento->especie ?? 'N/A' }}</div>


                                <span class="label">Sexo</span>
                                <div class="box gray">{{ $evento->sexo ?? 'N/A' }}</div>

                                <span class="label">Código de los Padres</span>
                                <div class="box">{{ $evento->codigo_padres ?? 'N/A' }}</div>

                                <span class="label">Señas Particulares</span>
                                <div class="box">{{ $evento->senas_particulares ?? 'N/A' }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            @elseif ($tipo === 'deceso')
            <tr>
                <td colspan="2">
                    <span class="label">Nombre Común</span>
                    <div class="box">{{ $evento->nombre_comun ?? 'N/A' }}</div>

                    <span class="label">Especie</span>
                    <div class="box" style="font-style: italic;">{{ $evento->especie ?? 'N/A' }}</div>


                    <span class="label">Causas del Deceso</span>
                    <div class="box">{{ $evento->causas_deceso ?? 'N/A' }}</div>

                    <div class="photo">
                        @if ($evento->foto)
                            <span class="label">Fotografía del Evento</span><br><br>
                            <img src="{{ public_path('storage/' . $evento->foto) }}" alt="Foto del evento">
                        @endif
                    </div>
                </td>
            </tr>

            @elseif ($tipo === 'fuga')
            <tr>
                <td colspan="2">
                    <span class="label">Código del Animal</span>
                    <div class="box">{{ $evento->codigo_animal ?? 'N/A' }}</div>

                    <span class="label">Nombre Común</span>
                    <div class="box">{{ $evento->nombre_comun ?? 'N/A' }}</div>

                    <span class="label">Especie</span>
                    <div class="box" style="font-style: italic;">{{ $evento->especie ?? 'N/A' }}</div>


                    <span class="label">Sexo</span>
                    <div class="box">{{ $evento->sexo ?? 'N/A' }}</div>

                    <span class="label">Fecha de Fuga</span>
                    <div class="box">
                        {{ $evento->fecha ? \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') : 'N/A' }}
                    </div>

                    <span class="label">Descripción de la Fuga</span>
                    <div class="box">
                        {!! nl2br(e($evento->descripcion_fuga ?? 'N/A')) !!}
                    </div>

                    <div class="photo">
                        @if ($evento->foto)
                            <span class="label">Fotografía del Evento</span><br><br>
                            <img src="{{ public_path('storage/' . $evento->foto) }}" alt="Foto del evento">
                        @else
                            <div style="border: 1px dashed #aaa; padding: 40px; border-radius: 10px;">
                                Sin fotografía
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
            @endif

            {{-- Observaciones --}}
            <tr>
                <td colspan="2">
                    <div class="section-title">Observaciones</div>
                    <div class="box">{{ $evento->observaciones ?? 'Sin observaciones' }}</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
