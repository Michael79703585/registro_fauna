@extends('layouts.app')

@section('title', 'Editar Registro de Fauna')

@section('content')
<form action="{{ route('fauna.update', $fauna->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <!-- Fecha de Ingreso -->
    <div class="form-group">
        <label for="fecha_ingreso">Fecha de Ingreso</label>
        <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $fauna->fecha_ingreso) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>

    <label for="fecha_recepcion">Fecha de Recepción</label>
    <input type="date" id="fecha_recepcion" name="fecha_recepcion" value="{{ old('fecha_recepcion', $fauna->fecha_recepcion) }}" required class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Ciudad -->
    <label for="ciudad">Ciudad</label>
    <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad', $fauna->ciudad) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Departamento -->
    <label for="departamento">Departamento</label>
    <input type="text" id="departamento" name="departamento" value="{{ old('departamento', $fauna->departamento) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Coordenadas -->
    <label for="coordenadas">Coordenadas</label>
    <input type="text" id="coordenadas" name="coordenadas" value="{{ old('coordenadas', $fauna->coordenadas) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Tipo de Elemento -->
    <label for="tipo_elemento">Tipo de Elemento</label>
    <select name="tipo_elemento" id="tipo_elemento" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        @foreach (['Animal Vivo', 'Parte', 'Derivado'] as $tipo)
            <option value="{{ $tipo }}" {{ old('tipo_elemento', $fauna->tipo_elemento) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
        @endforeach
    </select>

    <!-- Motivo de Ingreso -->
    <label for="motivo_ingreso">Motivo de Ingreso</label>
    <select name="motivo_ingreso" id="motivo_ingreso" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        @foreach (['Decomiso', 'Rescate', 'Captura', 'Otro'] as $motivo)
            <option value="{{ $motivo }}" {{ old('motivo_ingreso', $fauna->motivo_ingreso) == $motivo ? 'selected' : '' }}>{{ $motivo }}</option>
        @endforeach
    </select>

    <!-- Lugar -->
    <label for="lugar">Lugar</label>
    <input type="text" name="lugar" id="lugar" value="{{ old('lugar', $fauna->lugar) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Institución -->
    <label for="institucion_remitente">Institución Responsable</label>
    <input type="text" name="institucion_remitente" id="institucion_remitente" value="{{ old('institucion_remitente', $fauna->institucion_remitente) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Persona que recibe -->
    <label for="nombre_persona_recibe">Persona que Recibe</label>
    <input type="text" name="nombre_persona_recibe" id="nombre_persona_recibe" value="{{ old('nombre_persona_recibe', $fauna->nombre_persona_recibe) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Especie -->
    <label for="especie" class="italic">Especie</label>
    <input type="text" name="especie" id="especie" value="{{ old('especie', $fauna->especie) }}" class="w-full border-gray-300 rounded-md shadow-sm italic">

    <!-- Nombre común -->
    <label for="nombre_comun">Nombre Común</label>
    <input type="text" name="nombre_comun" id="nombre_comun" value="{{ old('nombre_comun', $fauna->nombre_comun) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Tipo de animal -->
    <label for="tipo_animal">Tipo de Animal</label>
    <select name="tipo_animal" id="tipo_animal" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        @foreach (['Mamífero', 'Ave', 'Reptil', 'Anfibio', 'Otro - Detallar'] as $tipo)
            <option value="{{ $tipo }}" {{ old('tipo_animal', $fauna->tipo_animal) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
        @endforeach
    </select>

    <!-- Edad Aparente -->
    <label for="edad_aparente">Edad Aparente</label>
    <select name="edad_aparente" id="edad_aparente" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        @foreach (['Neonato', 'Juvenil', 'Adulto', 'Geriátrico'] as $edad)
            <option value="{{ $edad }}" {{ old('edad_aparente', $fauna->edad_aparente) == $edad ? 'selected' : '' }}>{{ $edad }}</option>
        @endforeach
    </select>

    <!-- Estado General -->
    <label for="estado_general">Estado General</label>
    <input type="text" name="estado_general" id="estado_general" value="{{ old('estado_general', $fauna->estado_general) }}" class="w-full border-gray-300 rounded-md shadow-sm">

    <!-- Sexo -->
    <label for="sexo">Sexo</label>
    <select name="sexo" id="sexo" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        @foreach (['Macho', 'Hembra', 'Indeterminado'] as $sexo)
            <option value="{{ $sexo }}" {{ old('sexo', $fauna->sexo) == $sexo ? 'selected' : '' }}>{{ $sexo }}</option>
        @endforeach
    </select>

    <!-- Comportamiento -->
    <label for="comportamiento">Comportamiento</label>
    <select name="comportamiento" id="comportamiento" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        @foreach (['Aparentemente Normal', 'Tímido', 'Agresivo', 'Otro - Detallar'] as $comportamiento)
            <option value="{{ $comportamiento }}" {{ old('comportamiento', $fauna->comportamiento) == $comportamiento ? 'selected' : '' }}>{{ $comportamiento }}</option>
        @endforeach
    </select>

    <!-- Sospecha enfermedad -->
    <label for="sospecha_enfermedad">¿Sospecha de enfermedad?</label>
    <select name="sospecha_enfermedad" id="sospecha_enfermedad" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" {{ old('sospecha_enfermedad', $fauna->sospecha_enfermedad ? 'SI' : 'NO') == 'SI' ? 'selected' : '' }}>SI</option>
        <option value="NO" {{ old('sospecha_enfermedad', $fauna->sospecha_enfermedad ? 'SI' : 'NO') == 'NO' ? 'selected' : '' }}>NO</option>
    </select>
    <x-textarea-field name="descripcion_enfermedad" label="Descripción de Enfermedad" :value="old('descripcion_enfermedad', $fauna->descripcion_enfermedad)" />

    <x-textarea-field name="alteraciones_evidentes" label="Alteraciones Evidentes" :value="old('alteraciones_evidentes', $fauna->alteraciones_evidentes)" />
    <x-textarea-field name="otras_observaciones" label="Otras Observaciones" :value="old('otras_observaciones', $fauna->otras_observaciones)" />
    <x-input-field name="tiempo_cautiverio" label="Tiempo Cautiverio" :value="old('tiempo_cautiverio', $fauna->tiempo_cautiverio)" />
    <x-input-field name="tipo_alojamiento" label="Tipo Alojamiento" :value="old('tipo_alojamiento', $fauna->tipo_alojamiento)" />

    <!-- Contacto con animales -->
    <label for="contacto_con_animales">¿Tuvo contacto con animales?</label>
    <select name="contacto_con_animales" id="contacto_con_animales" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" {{ old('contacto_con_animales', $fauna->contacto_con_animales ? 'SI' : 'NO') == 'SI' ? 'selected' : '' }}>SI</option>
        <option value="NO" {{ old('contacto_con_animales', $fauna->contacto_con_animales ? 'SI' : 'NO') == 'NO' ? 'selected' : '' }}>NO</option>
    </select>
    <x-textarea-field name="descripcion_contacto" label="Descripción del Contacto con Animales" :value="old('descripcion_contacto', $fauna->descripcion_contacto)" />

    <!-- Padeció enfermedad -->
    <label for="padecio_enfermedad">¿Padeció enfermedad?</label>
    <select name="padecio_enfermedad" id="padecio_enfermedad" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" {{ old('padecio_enfermedad', $fauna->padecio_enfermedad ? 'SI' : 'NO') == 'SI' ? 'selected' : '' }}>SI</option>
        <option value="NO" {{ old('padecio_enfermedad', $fauna->padecio_enfermedad ? 'SI' : 'NO') == 'NO' ? 'selected' : '' }}>NO</option>
    </select>
    <x-textarea-field name="descripcion_padecimiento" label="Descripción de Padecimiento" :value="old('descripcion_padecimiento', $fauna->descripcion_padecimiento)" />

    <!-- Alimentación -->
    <x-textarea-field name="tipo_alimentacion" label="Tipo de Alimentación" :value="old('tipo_alimentacion', $fauna->tipo_alimentacion)" />

    <!-- Derivación a CCFS -->
    <label for="derivacion_ccfs">¿Derivado a CCFS?</label>
    <select name="derivacion_ccfs" id="derivacion_ccfs" class="w-full border-gray-300 rounded-md shadow-sm">
        <option value="">Seleccione</option>
        <option value="SI" {{ old('derivacion_ccfs', $fauna->derivacion_ccfs ? 'SI' : 'NO') == 'SI' ? 'selected' : '' }}>SI</option>
        <option value="NO" {{ old('derivacion_ccfs', $fauna->derivacion_ccfs ? 'SI' : 'NO') == 'NO' ? 'selected' : '' }}>NO</option>
    </select>
    <x-textarea-field name="descripcion_derivacion" label="Descripción de Derivación a CCFS" :value="old('descripcion_derivacion', $fauna->descripcion_derivacion)" />

    <!-- Imagen actual -->
    @if($fauna->foto)
        <p class="text-sm text-gray-600">Foto actual:</p>
        <img src="{{ asset('storage/' . $fauna->foto) }}" alt="Foto del animal" class="max-w-xs mb-2 rounded-md">
    @endif

    <label for="foto">Actualizar fotografía</label>
    <input type="file" name="foto" id="foto" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">

   <button type="submit" 
    class="mt-4 px-6 py-3 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 text-black font-bold rounded-lg shadow-lg hover:from-red-600 hover:via-pink-600 hover:to-purple-600 transition-all duration-300 transform hover:scale-105">
    Actualizar Registro
</button>
</form>
@endsection
