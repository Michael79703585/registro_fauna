@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-xl space-y-8">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-3xl font-extrabold text-indigo-700 flex items-center gap-3">
            <span class="text-4xl">📄</span> DETALLE DEL HISTORIAL CLÍNICO
        </h2>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('historial.edit', $historial->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow transition text-sm font-semibold">
                ✏️ Editar
            </a>

            <a href="{{ route('historial.pdf', $historial->id) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition text-sm font-semibold">
                📄 Exportar PDF
            </a>

            <form action="{{ route('historial.destroy', $historial->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este historial?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition text-sm font-semibold">
                    🗑️ Eliminar
                </button>
            </form>

            <a href="{{ route('historial.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow transition text-sm font-semibold">
                ← Volver al Listado
            </a>
        </div>
    </div>

    {{-- Información del animal --}}
    <div class="space-y-6">
        <h3 class="text-2xl font-semibold text-gray-800 border-b pb-2">🦜 Información del Animal</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
            <div><strong>Código:</strong> {{ $historial->fauna->codigo }}</div>
            <div><strong>Fecha de Recepción:</strong> {{ $historial->fauna->fecha_recepcion }}</div>
            <div><strong>Departamento:</strong> {{ $historial->fauna->departamento }}</div>
            <div><strong>Ciudad:</strong> {{ $historial->fauna->ciudad }}</div>
            <div><strong>Tipo de Animal:</strong> {{ $historial->fauna->tipo_animal }}</div>
            <div><strong>Nombre Común:</strong> {{ $historial->fauna->nombre_comun }}</div>
            <div><strong>Especie:</strong> <span class="italic">{{ $historial->fauna->especie }}</span></div>
            <div><strong>Edad Aparente:</strong> {{ $historial->fauna->edad_aparente }}</div>
            <div><strong>Sexo:</strong> {{ ucfirst($historial->fauna->sexo) }}</div>
            <div><strong>Comportamiento:</strong> {{ $historial->fauna->comportamiento }}</div>
        </div>

        <div class="text-gray-700">
            <strong>Otras Observaciones:</strong> <br>
            <p class="whitespace-pre-wrap mt-1">{{ $historial->fauna->otras_observaciones }}</p>
        </div>
    </div>

    {{-- Información médica --}}
    <div class="space-y-8 divide-y divide-gray-200 text-gray-700">

        <div class="pt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">🗓️ Fecha del Historial</h3>
            <p>{{ \Carbon\Carbon::parse($historial->fecha)->format('d/m/Y') }}</p>
        </div>

        <div class="pt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">🩺 Diagnóstico</h3>
            <p class="whitespace-pre-wrap">{{ $historial->diagnostico }}</p>
        </div>

        <div class="pt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">💊 Tratamiento</h3>
            <p class="whitespace-pre-wrap">{{ $historial->tratamiento ?? '-' }}</p>
        </div>

        <div class="pt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">📈 Evolución</h3>
            <p class="whitespace-pre-wrap">{{ $historial->observaciones ?? '-' }}</p>
        </div>

        <div class="pt-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="font-semibold text-lg">🧠 Etología (Comportamiento)</h3>
                <p class="whitespace-pre-wrap">{{ $historial->etologia ?? '-' }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">🥗 Nutrición</h3>
                <p class="whitespace-pre-wrap">{{ $historial->nutricion ?? '-' }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">🔬 Pruebas de Laboratorio</h3>
                <p class="whitespace-pre-wrap">{{ $historial->pruebas_laboratorio ?? '-' }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-lg">📌 Recomendaciones</h3>
                <p class="whitespace-pre-wrap">{{ $historial->recomendaciones ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Fotografía del Animal --}}
    @if(!empty($historial->foto_animal) && file_exists(public_path($historial->foto_animal)))
        <div class="mt-10">
            <h3 class="text-xl font-semibold text-gray-800 mb-3">📷 Fotografía del Animal</h3>
            <img src="{{ asset($historial->foto_animal) }}" alt="Foto del animal" class="max-w-sm rounded-xl shadow-md border border-gray-300">
        </div>
    @endif

    {{-- Archivo de Laboratorio --}}
    @if(!empty($historial->archivo_laboratorio) && file_exists(public_path($historial->archivo_laboratorio)))
        <div class="mt-10">
            <h3 class="text-xl font-semibold text-gray-800 mb-3">🧾 Archivo de Laboratorio</h3>

            @php
                $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                $extension = strtolower(pathinfo($historial->archivo_laboratorio, PATHINFO_EXTENSION));
                $archivoPath = asset($historial->archivo_laboratorio);
            @endphp

            @if(in_array($extension, $imageExtensions))
                <img src="{{ $archivoPath }}" alt="Archivo de laboratorio" class="max-w-sm rounded-xl shadow-md border border-gray-300">

            @elseif($extension === 'pdf')
                <iframe src="{{ $archivoPath }}" class="w-full h-[500px] border rounded-lg shadow-md" frameborder="0"></iframe>

            @else
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-gray-100 p-4 rounded-lg shadow-sm">
                    <span class="text-2xl">📎</span>
                    <div>
                        <p class="text-gray-700 mb-2">Este archivo no se puede previsualizar directamente.</p>
                        <a href="{{ $archivoPath }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition text-sm font-semibold">
                            🔗 Ver o Descargar Archivo
                        </a>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('historial.descargarArchivo', $historial->id) }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-blue px-4 py-2 rounded-lg shadow font-semibold transition">
                    ⬇️ Descargar Archivo de Laboratorio
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
