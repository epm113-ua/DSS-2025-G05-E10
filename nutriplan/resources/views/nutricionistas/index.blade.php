@extends('layouts.app')
@section('titulo', 'Nutricionistas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-person-badge me-2 text-success"></i>Nutricionistas</h2>
    <a href="{{ route('nutricionistas.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo nutricionista
    </a>
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('nutricionistas.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, especialidad o ciudad…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('nutricionistas.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                    function sortLink($campo, $label, $orden, $dir) {
                        $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                        $icon    = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                        $url     = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir, 'pagina' => 1]);
                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                    }
                @endphp
                <th>{!! sortLink('nombre_completo', 'Nombre', $orden, $dir) !!}</th>
                <th>{!! sortLink('especialidad', 'Especialidad', $orden, $dir) !!}</th>
                <th>{!! sortLink('ciudad', 'Ciudad', $orden, $dir) !!}</th>
                <th>Tienda</th>
                <th>{!! sortLink('valoracion_media', 'Valoración', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($nutricionistas as $n)
                <tr>
                    <td>{{ $n->nombre_completo }}</td>
                    <td>{{ $n->especialidad }}</td>
                    <td>{{ $n->ciudad }}</td>
                    <td>{{ $n->tienda->nombre_tienda ?? '—' }}</td>
                    <td>
                        <span class="badge bg-success">{{ number_format($n->valoracion_media, 1) }} / 5</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('nutricionistas.edit', $n) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('nutricionistas.destroy', $n) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este nutricionista?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay nutricionistas registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $nutricionistas->links() }}
</div>
@endsection
