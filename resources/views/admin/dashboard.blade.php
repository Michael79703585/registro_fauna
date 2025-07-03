@extends('layouts.app')

@section('styles')
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<style>
  /* === Tarjetas === */
  .card {
    border-radius: 1rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    border: none;
    overflow: hidden;
  }

  .card-header {
    padding: 1rem 1.5rem;
    font-weight: 700;
    font-size: 1.25rem;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-header.bg-primary {
    background: linear-gradient(135deg, #4a90e2, #357abd);
  }
  .card-header.bg-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
  }
  .card-header.bg-warning {
    background: linear-gradient(135deg, #ffc107, #d39e00);
    color: #212529;
  }

  /* === Tablas === */
  table {
    border-collapse: separate !important;
    border-spacing: 0 0.75rem !important;
    width: 100%;
  }

  thead tr th {
    background: #f1f3f5;
    border: none;
    border-radius: 0.5rem;
    font-weight: 700;
    padding: 0.75rem 1.25rem;
    color: #343a40;
    text-align: left;
  }

  tbody tr {
    background: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease, background 0.3s ease;
  }

  tbody tr:hover {
    background-color: #f0f8ff;
    box-shadow: 0 6px 16px rgba(53, 122, 189, 0.2);
  }

  tbody td {
    padding: 1rem 1.25rem;
    border: none;
    vertical-align: middle;
    color: #212529;
  }

  /* === Botones de acción === */
  .btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1rem;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    border: none;
  }

  .btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .btn-delete {
    background-color: #e55353;
    color: white;
  }
  .btn-delete:hover {
    background-color: #bf3e3e;
  }

  .btn-view {
    background-color: #17c1e8;
    color: #212529;
  }
  .btn-view:hover {
    background-color: #1391a8;
    color: #fff;
  }

  .btn-success.btn-action {
    background-color: #28a745;
    color: white;
  }
  .btn-success.btn-action:hover {
    background-color: #1e7e34;
  }

  /* === Badges === */
  .badge-admin {
    background-color: #198754;
    font-weight: 700;
    font-size: 0.8rem;
    padding: 0.35rem 0.75rem;
    border-radius: 0.6rem;
  }

  /* === Filtros === */
  .form-control::placeholder {
    font-style: italic;
    color: #6c757d;
  }

  .input-group-text {
    background: transparent;
    border: none;
    color: #6c757d;
    font-size: 1.2rem;
    padding-left: 0.5rem;
  }

  .form-control {
    border-left: none;
    border-radius: 0.375rem;
    transition: all 0.3s ease;
  }

  .form-control:focus {
    border-color: #357abd;
    box-shadow: 0 0 6px rgba(53, 122, 189, 0.5);
    outline: none;
  }

  /* === Botones filtros === */
  .btn-primary {
    background-color: #357abd;
    border: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-primary:hover {
    background-color: #285a8f;
  }

  .btn-outline-secondary {
    font-weight: 600;
  }

  /* === Responsive === */
  @media (max-width: 575.98px) {
    .btn-action {
      font-size: 0.85rem;
      padding: 0.4rem 0.8rem;
      gap: 0.3rem;
    }
    .card-header {
      font-size: 1.1rem;
      padding: 0.75rem 1rem;
    }
    thead tr th,
    tbody tr td {
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
    }
  }
</style>
@endsection

@section('content')
<div class="container py-4">
  <h2 class="mb-4 fw-bold text-primary">🎛️ Panel de Administración</h2>
@if (Auth::user()->isImpersonated())
  <div class="mb-4">
    <a href="{{ route('impersonate.leave') }}" class="btn btn-danger btn-sm">
      <i class="bi bi-box-arrow-left"></i> Salir del modo Admin
    </a>
  </div>
@endif


  {{-- Filtros --}}
  <form method="GET" class="row g-3 mb-5 align-items-end">
    <div class="col-md-3">
      <label for="usuario" class="form-label fw-semibold">Usuario</label>
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
        <input type="search" id="usuario" name="usuario" class="form-control" placeholder="Buscar por usuario" value="{{ request('usuario') }}" autocomplete="off" />
      </div>
    </div>
    
    <div class="col-md-3 d-flex gap-2">
      <button type="submit" class="btn btn-primary flex-grow-1">
        <i class="bi bi-funnel-fill"></i> Filtrar
      </button>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary flex-grow-1">
        <i class="bi bi-x-circle"></i> Limpiar
      </a>
    </div>
  </form>

  {{-- Usuarios --}}
  <div class="card mb-5">
    <div class="card-header bg-primary">
      👥 Lista de Usuarios ({{ $usuarios->total() }})
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th>Institución</th>
              <th class="text-center" style="width: 200px;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($usuarios as $usuario)
            <tr>
              <td class="fw-semibold">{{ $usuario->name }}</td>
              <td>
                {{ $usuario->email }}
                @if($usuario->email === 'michaelleon2109@gmail.com')
                <span class="badge badge-admin ms-2">Admin</span>
                @endif
              </td>
              <td>{{ optional($usuario->institucion)->nombre ?? 'N/A' }}</td>
              <td class="text-center d-flex justify-content-center gap-2 flex-wrap">
    <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-view btn-action">
        <i class="bi bi-person-circle"></i> Ver
    </a>

    {{-- Botón de impersonar --}}
    @if (Auth::user()->canImpersonate() && Auth::user()->id !== $usuario->id)
        <a href="{{ route('impersonate', $usuario->id) }}" class="btn btn-warning btn-sm btn-action">
            <i class="bi bi-person-bounding-box"></i> INSPECCIONAR
        </a>
    @endif

    @if($usuario->email !== 'michaelleon2109@gmail.com')
        <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Eliminar a {{ $usuario->name }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete btn-action">
                <i class="bi bi-trash3-fill"></i> Eliminar
            </button>
        </form>
    @else
        <span class="text-muted fst-italic align-self-center">No se puede eliminar</span>
    @endif
</td>

            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">No hay usuarios registrados.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="p-3">{{ $usuarios->links() }}</div>
    </div>
  </div>

 
 
@endsection
