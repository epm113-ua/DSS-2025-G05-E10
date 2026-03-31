@extends('layouts.app')
@section('titulo', 'Recetas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-journal-richtext me-2 text-success"></i>Recetas</h2>
    <a href="{{ route('recetas.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva receta
    </a>
</div>

<form method="GET" action="{{ route('recetas.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o preparación…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                <th>{!! colLink('nombre', 'Nombre', $orden, $dir) !!}</th>
                <th>Nutricionista</th>
                <th>{!! colLink('calorias_kcal', 'Kcal', $orden, $dir) !!}</th>
                <th>{!! colLink('carbohidratos_g', 'Carbohidratos (g)', $orden, $dir) !!}</th>
                <th>{!! colLink('grasas_g', 'Grasas (g)', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recetas as $r)
                <tr>
                    <td>{{ $r->nombre }}</td>
                    <td>{{ $r->nutricionista->nombre_completo ?? '—' }}</td>
                    <td>{{ $r->calorias_kcal }}</td>
                    <td>{{ number_format($r->carbohidratos_g, 1) }}</td>
                    <td>{{ number_format($r->grasas_g, 1) }}</td>
                    <td class="text-end">
                        <a href="{{ route('recetas.edit', $r) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('recetas.destroy', $r) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta receta?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay recetas registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">{{ $recetas->total() }} resultado(s)</small>
    {{ $recetas->links() }}
</div>
@endsection
