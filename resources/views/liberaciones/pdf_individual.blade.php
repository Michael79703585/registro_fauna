{{-- resources/views/liberaciones/pdf_individual.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Formulario Liberación - {{ $liberacion->codigo }}</title>
<style>
    @page {
        margin: 20px 25px;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        color: #2c3e50;
        margin: 0;
        padding: 0;
        line-height: 1.3;
    }
    h1 {
        font-size: 16pt;
        text-align: center;
        margin-bottom: 15px;
        font-weight: 700;
        color: #1a2a40;
        border-bottom: 2px solid #2980b9;
        padding-bottom: 6px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: avoid;
    }
    td {
        vertical-align: top;
        padding: 6px 8px;
        border: 1px solid #d0d7de;
        background: #f9fbfd;
        word-wrap: break-word;
        max-width: 48%;
    }
    td.label {
        font-weight: 700;
        color: #527a9e;
        width: 35%;
        white-space: nowrap;
        user-select: none;
    }
    td.value {
        width: 65%;
    }
    .section-title {
        background: transparent;
        color: #2980b9;
        font-weight: 700;
        font-size: 12pt;
        border: none;
        padding: 12px 0 6px 0;
        text-align: left;
        user-select: none;
    }
    .observaciones {
        white-space: pre-wrap;
        font-style: italic;
        max-height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .photo-container {
        text-align: center;
        margin-top: 25px;
        border-top: 2px solid #2980b9;
        padding-top: 12px;
    }
    .photo-container img {
        max-width: 300px;
        max-height: 320px;
        border-radius: 8px;
        border: 1px solid #d0d7de;
        object-fit: contain;
        box-shadow: 0 0 8px rgba(41, 128, 185, 0.2);
    }
    .footer {
        margin-top: 20px;
        font-size: 8pt;
        color: #7f8c8d;
        text-align: center;
        border-top: 1px solid #d0d7de;
        padding-top: 6px;
        font-style: italic;
        user-select: none;
    }
</style>
</head>
<body>

<h1>Formulario de Liberación</h1>

@php
    $imageBase64 = null;
    $imagePath = storage_path('app/public/' . $liberacion->fotografia);
    if ($liberacion->fotografia && file_exists($imagePath)) {
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
    }
@endphp

<table>
    <tr><td class="label">Fecha</td><td class="value">{{ \Carbon\Carbon::parse($liberacion->fecha)->format('d/m/Y') }}</td></tr>
    <tr><td class="section-title" colspan="2">Datos del Animal</td></tr>
    <tr><td class="label">Código</td><td class="value">{{ $liberacion->codigo }}</td></tr>
    <tr><td class="label">Tipo de Animal</td><td class="value">{{ $liberacion->tipo_animal }}</td></tr>
    <tr>
    <td class="label">Especie</td>
    <td class="value"><em>{{ $liberacion->especie }}</em></td>
</tr>
    <tr><td class="label">Nombre Común</td><td class="value">{{ $liberacion->nombre_comun }}</td></tr>

    <tr><td class="section-title" colspan="2">Datos de la actividad</td></tr>

    <tr><td class="label">Lugar de Liberación</td><td class="value">{{ $liberacion->lugar ?? $liberacion->lugar_liberacion }}</td></tr>
    <tr><td class="label">Departamento</td><td class="value">{{ $liberacion->departamento }}</td></tr>
    <tr><td class="label">Municipio</td><td class="value">{{ $liberacion->municipio }}</td></tr>
    <tr><td class="label">Coordenadas</td><td class="value">{{ $liberacion->coordenadas ?? '-' }}</td></tr>
    <tr><td class="label">Responsable</td><td class="value">{{ $liberacion->responsable }}</td></tr>
    <tr><td class="label">Institución</td><td class="value">{{ $liberacion->institucion }}</td></tr>
    <tr>
        <td class="label">Observaciones</td>
        <td class="value observaciones">{{ $liberacion->observaciones ?? '-' }}</td>
    </tr>
</table>
@php
    $imageBase64 = null;
    if ($liberacion->foto) {
        $imagePath = storage_path('app/public/' . $liberacion->foto);
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
            $imageBase64 = 'data:image/' . $imageType . ';base64,' . $imageData;
        }
    }
@endphp

@if($imageBase64)
    <div class="photo-container">
        <img src="{{ $imageBase64 }}" alt="Fotografía del Animal" />
    </div>
@else
    <p><em>Sin fotografía disponible</em></p>
@endif


<div class="footer">
    Cochabamba - {{ \Carbon\Carbon::now()->format('d/m/Y') }}
</div>

</body>
</html>
