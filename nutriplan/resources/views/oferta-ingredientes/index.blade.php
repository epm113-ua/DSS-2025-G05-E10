@extends('layouts.app')
@section('titulo', 'Ofertas de ingredientes')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-tag me-2 text-success"></i>Ofertas de ingredientes</h2>
    <a href="{{ route('oferta-ingredientes.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva oferta
    </a>
</div>

<form method="GET" action="{{ route('oferta-ingredientes.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o descripción…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('oferta-ingredientes.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
    </div>
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
                <th>Ingrediente</th>
                <th>Tienda</th>
                <th>{!! colLink('descripcion_oferta', 'Descripción', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($ofertas as $o)
                <tr>
                    <td>{{ $o->nombre }}</td>
                    <td>{{ $o->ingrediente->nombre ?? '—' }}</td>
                    <td>{{ $o->tienda->nombre_tienda ?? '—' }}</td>
                    <td>{{ Str::limit($o->descripcion_oferta, 60) }}</td>
                    <td class="text-end">
                        <a href="{{ route('oferta-ingredientes.edit', $o) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('oferta-ingredientes.destroy', $o) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta oferta?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay ofertas registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $ofertas->links() }}
</div>
@endsection
