@extends('layouts.app')
@section('titulo','Gestión de usuarios')
@section('breadcrumb','Admin › Usuarios')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-success"></i>Gestión de Usuarios</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary btn-sm">← Panel</a>
        <a href="{{ route('admin.usuarios.crear') }}" class="btn btn-success btn-sm"><i class="bi bi-person-plus me-1"></i>Nuevo usuario</a>
    </div>
</div>

<form method="GET" action="{{ route('admin.usuarios') }}" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Nombre o email..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <select name="rol" class="form-select form-select-sm">
                    <option value="">Todos los roles</option>
                    <option value="admin"         @selected(request('rol')=='admin')>Admin</option>
                    <option value="nutricionista" @selected(request('rol')=='nutricionista')>Nutricionista</option>
                    <option value="paciente"      @selected(request('rol')=='paciente')>Paciente</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
            </div>
        </div>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th style="width:44px"></th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Vinculado a</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $u)
                @php
                    $colores = ['admin'=>'danger','nutricionista'=>'primary','paciente'=>'success'];
                    // Obtener foto según el rol vinculado
                    $foto = null;
                    if ($u->nutricionista && $u->nutricionista->foto) {
                        $foto = $u->nutricionista->foto;
                    } elseif ($u->paciente && $u->paciente->foto) {
                        $foto = $u->paciente->foto;
                    }
                    // Iniciales del nombre
                    $parts = explode(' ', trim($u->name));
                    $initials = strtoupper(substr($parts[0],0,1)) . (isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
                    $bgColor = ['admin'=>'#dc3545','nutricionista'=>'#0d6efd','paciente'=>'#198754'][$u->rol] ?? '#6c757d';
                @endphp
                <tr>
                    <td class="text-muted small">{{ $u->id }}</td>
                    <td>
                        @if($foto)
                            <img src="{{ asset('storage/'.$foto) }}"
                                 class="rounded-circle" style="width:32px;height:32px;object-fit:cover" alt="foto">
                        @else
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
                                 style="width:32px;height:32px;font-size:.62rem;background:{{ $bgColor }}">
                                {{ $initials }}
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td class="small">{{ $u->email }}</td>
                    <td>
                        <span class="badge bg-{{ $colores[$u->rol] ?? 'secondary' }} text-capitalize">{{ $u->rol }}</span>
                    </td>
                    <td class="small text-muted">
                        @if($u->paciente) Paciente: {{ $u->paciente->nombre_completo }}
                        @elseif($u->nutricionista) Nutricionista: {{ $u->nutricionista->nombre_completo }}
                        @else —
                        @endif
                    </td>
                    <td class="text-end">
                        @if($u->id !== Auth::id())
                            <form method="POST" action="{{ route('admin.usuarios.toggle',$u) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning" title="{{ $u->esAdmin()?'Quitar admin':'Hacer admin' }}">
                                    <i class="bi bi-shield{{ $u->esAdmin()?'-x':'-check' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.usuarios.eliminar',$u) }}" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar a {{ $u->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @else
                            <span class="text-muted small">(tú)</span>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No hay usuarios.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $usuarios->links() }}</div>
@endsection
