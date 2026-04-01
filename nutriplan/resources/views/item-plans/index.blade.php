@extends('layouts.app')
@section('titulo', 'Items de Plan')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-list-check me-2 text-success"></i>Ítems de Plan</h2>
    <a href="{{ route('item-plans.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo ítem
    </a>
</div>

<form method="GET" action="{{ route('item-plans.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por tipo de comida o notas…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('item-plans.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
    </div>
    <input type="hidden" name="orden" value="{{ $orden }}">
    <input type="hidden" name="dir"   value="{{ $dir }}">
</form>

@php
    $dias = [1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado',7=>'Domingo'];
    function colLink($campo, $label, $orden, $dir) {
        $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
        $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
        $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
    }
@endphp
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-success">
            <tr>
                <th>Plan semanal</th>
                <th>Receta</th>
                <th>{!! colLink('dia_semana', 'Día', $orden, $dir) !!}</th>
                <th>{!! colLink('tipo_comida', 'Tipo comida', $orden, $dir) !!}</th>
                <th>Notas</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>#{{ $item->plan_semanal_id }} – {{ $item->planSemanal->semana_inicio ?? '' }}</td>
                    <td>{{ $item->receta->nombre ?? '—' }}</td>
                    <td>{{ $dias[$item->dia_semana] ?? $item->dia_semana }}</td>
                    <td>{{ $item->tipo_comida }}</td>
                    <td>{{ Str::limit($item->notas, 40) ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('item-plans.edit', $item) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('item-plans.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este ítem?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay ítems de plan registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $items->links() }}
</div>
@endsection
