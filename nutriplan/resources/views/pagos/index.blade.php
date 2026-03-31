@extends('layouts.app')
@section('titulo', 'Pagos')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-credit-card me-2 text-success"></i>Pagos</h2>
    <a href="{{ route('pagos.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo pago
    </a>
</div>

<form method="GET" action="{{ route('pagos.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por titular o número de factura…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                <th>Factura</th>
                <th>{!! colLink('nombre_titular', 'Titular', $orden, $dir) !!}</th>
                <th>{!! colLink('fecha_pago', 'Fecha de pago', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pagos as $p)
                <tr>
                    <td>{{ $p->factura->numero_factura ?? '—' }}</td>
                    <td>{{ $p->nombre_titular }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('pagos.edit', $p) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pagos.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este pago?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay pagos registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">{{ $pagos->total() }} resultado(s)</small>
    {{ $pagos->links() }}
</div>
@endsection
