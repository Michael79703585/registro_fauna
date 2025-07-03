@extends('layouts.app')

@section('title', 'Recepciones de Fauna Silvestre')
@section('content')
<div class="container">

    {{-- Buscador --}}
    <div class="card shadow mb-4 border-0 animate__animated animate__fadeInDown">
        <div class="card-body">
            <form method="GET" action="{{ url('/recepciones') }}">
                <div class="input-group">
                    <input type="text" name="codigo" placeholder="🔍 Buscar por código de fauna" value="{{ request('codigo') }}" class="form-control form-control-lg shadow-sm rounded-start">
                    <button type="submit" class="btn btn-primary btn-lg rounded-end">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Transferencias Aceptadas --}}
    <div class="card shadow mb-4 border-0 animate__animated animate__fadeInLeft">
    <div class="card-header bg-white border-bottom shadow-sm">
        <h5 class="mb-0 fw-bold text-uppercase" style="font-size: 1.25rem; letter-spacing: 0.5px; color: #0d6efd;">
            📦 Transferencias Aceptadas en tu Institución
        </h5>
    </div>
        <div class="card-body">
            @if($transferencias->isEmpty())
                <p class="text-muted fst-italic">No hay transferencias aceptadas.</p>
            @else
                @foreach($transferencias as $transferencia)
                    <div class="border rounded-3 p-4 mb-4 shadow-sm transition hover-shadow bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <p class="mb-1"><strong>Fauna:</strong> {{ $transferencia->fauna->codigo ?? 'Sin código' }}</p>
                                <p class="mb-1"><strong>Motivo:</strong> {{ $transferencia->motivo ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Estado:</strong>
                                    <span class="badge bg-warning text-dark">{{ $transferencia->estado }}</span>
                                </p>
                                <p class="mb-1"><strong>Registrado por:</strong> {{ $transferencia->fauna->user->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Institución origen:</strong> {{ $transferencia->fauna->user->institucion->nombre ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <a href="{{ route('recepciones.pdf', $transferencia->fauna->id) }}" class="btn btn-outline-success btn-sm">
                                    📥 Descargar PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Faunas Registradas --}}
    <div class="card-header bg-white border-bottom shadow-sm">
    <h5 class="mb-0 fw-bold text-uppercase" style="font-size: 1.25rem; letter-spacing: 0.5px; color: #0d6efd;">
        🦜 Fauna Registrada en tu Institución
    </h5>
</div>



        <div class="card-body">
            @if($faunas->isEmpty())
                <p class="text-muted fst-italic">No hay faunas registradas en tu institución.</p>
            @else
                @foreach($faunas as $fauna)
                    <div class="border rounded-3 p-4 mb-4 shadow-sm bg-light transition hover-shadow">
                        <p class="mb-1"><strong>Código:</strong> {{ $fauna->codigo }}</p>
                        <p class="mb-1"><strong>Especie:</strong> {{ $fauna->especie }}</p>
                        <p class="mb-1"><strong>Ingreso:</strong> {{ $fauna->fecha_ingreso }}</p>
                        <p class="mb-1"><strong>Registrado por:</strong> {{ $fauna->user->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Institución:</strong> {{ $fauna->user->institucion->nombre ?? 'N/A' }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>
@endsection
