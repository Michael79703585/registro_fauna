@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6 text-center">  📑 Editar Historial Clínico</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('historial.update', $historial->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="fauna_id" class="block font-semibold mb-1">Animal</label>
            <select name="fauna_id" id="fauna_id" class="w-full border px-4 py-2 rounded" required>
                @foreach ($faunas as $fauna)
                    <option value="{{ $fauna->id }}" {{ (old('fauna_id', $historial->fauna_id) == $fauna->id) ? 'selected' : '' }}>
                        {{ $fauna->codigo }} - {{ $fauna->nombre_comun ?? 'Sin nombre' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="fecha" class="block font-semibold mb-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $historial->fecha) }}" class="w-full border px-4 py-2 rounded" required>
        </div>

        <div class="bg-gray-50 p-4 rounded">
            <h2 class="text-xl font-bold mb-4">Examen General</h2>

            @php
                $campos = [
                    'condicion_corporal' => 'Condición Corporal',
                    'boca' => 'Boca',
                    'piel' => 'Piel y Anexos',
                    'musculo_esqueletico' => 'Músculo Esquelético',
                    'abdomen' => 'Abdomen',
                    'frecuencia_cardiaca' => 'Frecuencia Cardíaca',
                    'frecuencia_respiratoria' => 'Frecuencia Respiratoria',
                    'temperatura' => 'Temperatura',
                    'mucosas' => 'Examen de Mucosas',
                    'plumas_pico_garras' => 'En caso de aves: Plumas, Pico, Garras',
                    'caparazon_plastrom' => 'En caso de reptiles: Caparazón, Plastrom, Cabeza, Miembros anteriores y posteriores',
                ];

                $examen_general = old('examen_general') 
                    ?? (is_string($historial->examen_general) ? json_decode($historial->examen_general, true) : ($historial->examen_general ?? []));
            @endphp

            @foreach ($campos as $name => $label)
                <div class="mb-4">
                    <label for="{{ $name }}" class="block font-semibold mb-1">{{ $label }}</label>
                    <textarea name="examen_general[{{ $name }}]" id="{{ $name }}" rows="2" class="w-full border px-4 py-2 rounded">{{ $examen_general[$name] ?? '' }}</textarea>
                </div>
            @endforeach

            <div class="mb-4">
                <label for="foto_animal" class="block font-semibold mb-1">Fotografía del Animal</label>
                @if(!empty($historial->foto_animal))
                    <div class="mb-2">
                        <img src="{{ asset($historial->foto_animal) }}" alt="Foto Animal" class="max-w-xs rounded shadow">
                    </div>
                @endif
                <input type="file" name="foto_animal" id="foto_animal" class="w-full border px-4 py-2 rounded">
            </div>
        </div>

        <div>
            <label for="etologia" class="block font-semibold mb-1">Comportamiento (Etología)</label>
            <textarea name="etologia" id="etologia" rows="3" class="w-full border px-4 py-2 rounded">{{ old('etologia', $historial->etologia) }}</textarea>
        </div>

        <div>
            <label for="diagnostico" class="block font-semibold mb-1">Diagnóstico</label>
            <textarea name="diagnostico" id="diagnostico" rows="3" class="w-full border px-4 py-2 rounded" required>{{ old('diagnostico', $historial->diagnostico) }}</textarea>
        </div>

        <div>
            <label for="tratamiento" class="block font-semibold mb-1">Tratamiento</label>
            <textarea name="tratamiento" id="tratamiento" rows="3" class="w-full border px-4 py-2 rounded">{{ old('tratamiento', $historial->tratamiento) }}</textarea>
        </div>

        <div>
            <label for="nutricion" class="block font-semibold mb-1">Nutrición</label>
            <textarea name="nutricion" id="nutricion" rows="3" class="w-full border px-4 py-2 rounded">{{ old('nutricion', $historial->nutricion) }}</textarea>
        </div>

        <div>
            <label for="pruebas_laboratorio" class="block font-semibold mb-1">Pruebas de Laboratorio</label>
            <textarea name="pruebas_laboratorio" id="pruebas_laboratorio" rows="3" class="w-full border px-4 py-2 rounded">{{ old('pruebas_laboratorio', $historial->pruebas_laboratorio) }}</textarea>
        </div>

<!-- Sección de Pruebas de Laboratorio -->
<div>
    <label for="pruebas_laboratorio" class="block font-semibold mb-1">Pruebas de Laboratorio</label>
    <textarea name="pruebas_laboratorio" id="pruebas_laboratorio" rows="3" class="w-full border px-4 py-2 rounded">{{ old('pruebas_laboratorio', $historial->pruebas_laboratorio) }}</textarea>
</div>

<!-- NUEVA SECCIÓN: Cargar PDF o Imagen de Resultados de Laboratorio -->
<div class="mb-6">
    <label for="archivo_laboratorio" class="block font-semibold mb-1">Archivo de Resultados de Laboratorio (PDF o Imagen)</label>
    
    @if(!empty($historial->archivo_laboratorio))
        <div class="mb-2">
            @if(Str::endsWith($historial->archivo_laboratorio, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset($historial->archivo_laboratorio) }}" alt="Archivo Actual" class="max-w-xs rounded shadow">
            @elseif(Str::endsWith($historial->archivo_laboratorio, ['.pdf']))
                <a href="{{ asset($historial->archivo_laboratorio) }}" target="_blank" class="text-blue-600 underline">Ver archivo PDF actual</a>
            @endif
        </div>
    @endif

    <input type="file" name="archivo_laboratorio" id="archivo_laboratorio" accept=".pdf,image/*" class="w-full border px-4 py-2 rounded">
    <small class="text-gray-500">Opcional. Formatos permitidos: PDF, JPG, PNG.</small>
</div>


        <div>
            <label for="recomendaciones" class="block font-semibold mb-1">Recomendaciones</label>
            <textarea name="recomendaciones" id="recomendaciones" rows="3" class="w-full border px-4 py-2 rounded">{{ old('recomendaciones', $historial->recomendaciones) }}</textarea>
        </div>

        <div>
            <label for="observaciones" class="block font-semibold mb-1">Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3" class="w-full border px-4 py-2 rounded">{{ old('observaciones', $historial->observaciones) }}</textarea>
        </div>

        <div class="flex justify-between items-center mt-6">

    <!-- Botón Cancelar -->
    <a href="{{ route('historial.index') }}"
   style="display: inline-flex; align-items: center; gap: 6px; font-size: 16px; font-weight: 600; color: #374151; text-decoration: none;"
   onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#374151'">
   <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M15 19l-7-7 7-7" />
   </svg>
   Cancelar
</a>


    <!-- Botón Actualizar -->
    <button type="submit"
            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-lg shadow transition duration-150">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7" />
        </svg>
        Actualizar
    </button>
</div>

    </form>
</div>
@endsection
