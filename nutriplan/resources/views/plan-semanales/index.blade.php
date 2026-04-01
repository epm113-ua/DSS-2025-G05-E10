@extends('layouts.app')
@section('titulo', 'Planes Semanales')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-calendar-week me-2 text-success"></i>Planes Semanales</h2>
    <a href="{{ route('plan-semanales.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo plan
    </a>
</div>

<form method="GET" action="{{ route('plan-semanales.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por notas o fecha…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('plan-semanales.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                        $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                        $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                    }
                @endphp
                <th>{!! colLink('semana_inicio', 'Semana inicio', $orden, $dir) !!}</th>
                <th>Cita / Paciente</th>
                <th>{!! colLink('notas', 'Notas', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($planes as $p)
                <tr>
                    <td>{{ $p->semana_inicio }}</td>
                    <td>{{ $p->cita->paciente->nombre_completo ?? 'Cita #' . $p->cita_id }}</td>
                    <td>{{ Str::limit($p->notas, 60) ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('plan-semanales.edit', $p) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('plan-semanales.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este plan?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay planes semanales registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $planes->links() }}
</div>
@endsection
