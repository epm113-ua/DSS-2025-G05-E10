@extends('layouts.app')
@section('titulo', 'Gestión de usuarios')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2 text-warning"></i>Gestión de usuarios</h2>
    <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver al Admin
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-warning">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
            @forelse($usuarios as $u)
                <tr>
                    <td class="text-muted">{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->is_admin)
                            <span class="badge bg-warning text-dark"><i class="bi bi-shield-fill me-1"></i>Admin</span>
                        @else
                            <span class="badge bg-light text-muted border">Usuario</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <form action="{{ route('admin.toggle-admin', $u) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Cambiar el rol de este usuario?')">
                            @csrf
                            <button class="btn btn-sm {{ $u->is_admin ? 'btn-outline-danger' : 'btn-outline-warning' }}">
                                @if($u->is_admin)
                                    <i class="bi bi-shield-x me-1"></i>Quitar admin
                                @else
                                    <i class="bi bi-shield-plus me-1"></i>Hacer admin
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay usuarios registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $usuarios->links() }}</div>
@endsection
