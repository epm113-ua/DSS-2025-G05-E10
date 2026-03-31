@extends('layouts.app')
@section('titulo', 'Mensajes')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-envelope me-2 text-success"></i>Mensajes</h2>
    <a href="{{ route('mensajes.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo mensaje
    </a>
</div>

<form method="GET" action="{{ route('mensajes.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por contenido…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                <th>{!! colLink('enviado_en', 'Enviado', $orden, $dir) !!}</th>
                <th>Conversación</th>
                <th>{!! colLink('contenido', 'Contenido', $orden, $dir) !!}</th>
                <th>Factura</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($mensajes as $m)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($m->enviado_en)->format('d/m/Y H:i') }}</td>
                    <td>#{{ $m->conversacion_id }}</td>
                    <td>{{ Str::limit($m->contenido, 60) }}</td>
                    <td>{{ $m->factura->numero_factura ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('mensajes.edit', $m) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('mensajes.destroy', $m) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este mensaje?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay mensajes registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">{{ $mensajes->total() }} resultado(s)</small>
    {{ $mensajes->links() }}
</div>
@endsection
