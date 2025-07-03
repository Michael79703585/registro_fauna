@extends('layouts.app')

@section('title', 'Crear Evento Genérico')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Crear Evento Genérico</h1>

    <form action="{{ route('eventos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- Tipo de Evento --}}
        <div class="mb-3">
            <label for="tipo_evento_id" class="form-label">Tipo de Evento <span class="text-danger">*</span></label>
            <select name="tipo_evento_id" id="tipo_evento_id" 
                class="form-select @error('tipo_evento_id') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($tiposEvento as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_evento_id') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('tipo_evento_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
            <input type="date" name="fecha" id="fecha" 
                class="form-control @error('fecha') is-invalid @enderror" 
                value="{{ old('fecha') }}" required>
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fauna --}}
        <div class="mb-3">
            <label for="fauna_id" class="form-label">Fauna</label>
            <select name="fauna_id" id="fauna_id" class="form-select @error('fauna_id') is-invalid @enderror">
                <option value="">Seleccione</option>
                @foreach($faunas as $fauna)
                    <option value="{{ $fauna->id }}" {{ old('fauna_id') == $fauna->id ? 'selected' : '' }}>
                        {{ $fauna->nombre }}
                    </option>
                @endforeach
            </select>
            @error('fauna_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Institución --}}
        <div class="mb-3">
            <label for="institucion_id" class="form-label">Institución</label>
            <select name="institucion_id" id="institucion_id" class="form-select @error('institucion_id') is-invalid @enderror">
                <option value="">Seleccione</option>
                @foreach($instituciones as $institucion)
                    <option value="{{ $institucion->id }}" {{ old('institucion_id') == $institucion->id ? 'selected' : '' }}>
                        {{ $institucion->nombre }}
                    </option>
                @endforeach
            </select>
            @error('institucion_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Observaciones --}}
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3" 
                class="form-control @error('observaciones') is-invalid @enderror">{{ old('observaciones') }}</textarea>
            @error('observaciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Foto --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Foto (jpg, jpeg, png)</label>
            <input type="file" name="foto" id="foto" 
                class="form-control @error('foto') is-invalid @enderror" 
                accept=".jpg,.jpeg,.png">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">Guardar Evento</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
