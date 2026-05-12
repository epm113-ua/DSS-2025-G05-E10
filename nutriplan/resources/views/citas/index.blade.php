@extends('layouts.app')
@section('titulo', 'Citas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-calendar-check me-2 text-success"></i>Citas</h2>
    <a href="{{ route('citas.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva cita
    </a>
</div>

<form method="GET" action="{{ route('citas.index') }}" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-2">
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente"  @selected(request('estado')==='pendiente')>Pendiente</option>
                    <option value="completada" @selected(request('estado')==='completada')>Completada</option>
                    <option value="cancelada"  @selected(request('estado')==='cancelada')>Cancelada</option>
                </select>
            </div>
            @isset($nutricionistas)
            <div class="col-md-2">
                <select name="nutricionista_id" class="form-select">
                    <option value="">Todos los nutricionistas</option>
                    @foreach($nutricionistas as $n)
                        <option value="{{ $n->id }}" @selected(request('nutricionista_id') == $n->id)>{{ $n->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            @endisset
            @isset($pacientes)
            <div class="col-md-2">
                <select name="paciente_id" class="form-select">
                    <option value="">Todos los pacientes</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(request('paciente_id') == $p->id)>{{ $p->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            @endisset
            <div class="col-md-3 d-flex gap-2">
                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}" title="Desde">
                <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}" title="Hasta">
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
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
                    if (!function_exists('colLink')) {
                        function colLink($campo, $label, $orden, $dir) {
                            $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                            $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                            $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                            return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                        }
                    }
                @endphp
                <th>{!! colLink('inicio', 'Inicio', $orden, $dir) !!}</th>
                <th>{!! colLink('fin', 'Fin', $orden, $dir) !!}</th>
                <th>Paciente</th>
                <th>Nutricionista</th>
                <th>{!! colLink('estado', 'Estado', $orden, $dir) !!}</th>
                <th>{!! colLink('motivo', 'Motivo', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @php
                $badgeEstado = ['pendiente' => 'warning', 'completada' => 'success', 'cancelada' => 'danger'];
            @endphp
            @forelse($citas as $c)
                <tr>
                    <td>{{ $c->inicio->format('d/m/Y H:i') }}</td>
                    <td>{{ $c->fin->format('d/m/Y H:i') }}</td>
                    <td>{{ $c->paciente->nombre_completo ?? '—' }}</td>
                    <td>{{ $c->nutricionista->nombre_completo ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $badgeEstado[$c->estado] ?? 'secondary' }}">{{ ucfirst($c->estado) }}</span>
                    </td>
                    <td>{{ Str::limit($c->motivo, 40) }}</td>
                    <td class="text-end">
                        <a href="{{ route('citas.edit', $c) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('citas.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta cita?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay citas registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $citas->links() }}
</div>
@endsection
