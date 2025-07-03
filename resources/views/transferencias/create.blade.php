@extends('layouts.app')

@section('title', 'Registrar Transferencia')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4">🔁 Registrar Transferencia</h2>

    <form action="{{ route('transferencias.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="fauna_id" class="block font-medium">Animal</label>
            <select name="fauna_id" id="fauna_id" required class="w-full border rounded p-2">
                <option value="">Seleccione un animal</option>
                @foreach ($faunas as $fauna)
                    <option 
                        value="{{ $fauna->id }}" 
                        data-especie="{{ $fauna->especie }}" 
                        data-nombrecomun="{{ $fauna->nombre_comun ?? 'N/A' }}"
                        {{ old('fauna_id') == $fauna->id ? 'selected' : '' }}>
                        {{ $fauna->codigo }} - {{ $fauna->especie }}
                    </option>
                @endforeach
            </select>
            @error('fauna_id') <small class="text-red-500">{{ $message }}</small> @enderror
            <div id="info-fauna" class="mt-2 text-gray-700"></div>
        </div>

        {{-- Institución Origen: ya no se muestra ni se envía desde el formulario --}}

        <div class="mb-4">
            <label for="institucion_destino" class="block font-medium">Institución Destino</label>
            <select name="institucion_destino" class="form-control">
                @foreach($instituciones as $institucion)
                    <option value="{{ $institucion->id }}">{{ $institucion->nombre }}</option>
                @endforeach
            </select>
            @error('institucion_destino') <small class="text-red-500">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="motivo" class="block font-medium">Motivo</label>
            <input type="text" name="motivo" value="{{ old('motivo') }}" class="w-full border rounded p-2" />
            @error('motivo') <small class="text-red-500">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="observaciones" class="block font-medium">Observaciones</label>
            <textarea name="observaciones" rows="3" class="w-full border rounded p-2">{{ old('observaciones') }}</textarea>
            @error('observaciones') <small class="text-red-500">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">
            Enviar Solicitud
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('fauna_id');
        const infoDiv = document.getElementById('info-fauna');

        function updateInfo() {
            const selectedOption = select.options[select.selectedIndex];
            if (select.value === "") {
                infoDiv.innerHTML = "";
                return;
            }
            const especie = selectedOption.getAttribute('data-especie') || '';
            const nombreComun = selectedOption.getAttribute('data-nombrecomun') || '';

            infoDiv.innerHTML = `<p><em>Especie:</em> ${especie}</p>
                                 <p><em>Nombre común:</em> ${nombreComun}</p>`;
        }

        updateInfo();

        select.addEventListener('change', updateInfo);
    });
</script>
@endsection
