@extends('layouts.app')
@section('titulo', 'Pacientes')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-people me-2 text-success"></i>Pacientes</h2>
    <a href="{{ route('pacientes.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo paciente
    </a>
</div>

<form method="GET" action="{{ route('pacientes.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o ciudad…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
    </div>
    <input type="hidden" name="orden" value="{{ $orden }}">
    <input type="hidden" name="dir"   value="{{ $dir }}">
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-success">
            <tr>
                @php
                    function colLink($campo, $label, $orden, $dir) {
                        $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                        $icon    = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                        $url     = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                    }
                @endphp
                <th>{!! colLink('nombre_completo', 'Nombre', $orden, $dir) !!}</th>
                <th>{!! colLink('fecha_nacimiento', 'F. Nacimiento', $orden, $dir) !!}</th>
                <th>{!! colLink('ciudad', 'Ciudad', $orden, $dir) !!}</th>
                <th>Nutricionista</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pacientes as $p)
                <tr>
                    <td>{{ $p->nombre_completo }}</td>
                    <td>{{ $p->fecha_nacimiento }}</td>
                    <td>{{ $p->ciudad }}</td>
                    <td>{{ $p->nutricionista->nombre_completo ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('pacientes.edit', $p) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pacientes.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este paciente?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay pacientes registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $pacientes->links() }}
</div>
@endsection
