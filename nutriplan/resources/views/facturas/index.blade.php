@extends('layouts.app')
@section('titulo', 'Facturas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-receipt me-2 text-success"></i>Facturas</h2>
    <a href="{{ route('facturas.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva factura
    </a>
</div>

<form method="GET" action="{{ route('facturas.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por número de factura…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('facturas.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                <th>{!! colLink('numero_factura', 'Número', $orden, $dir) !!}</th>
                <th>Paciente</th>
                <th>{!! colLink('pagado_en', 'Pagado el', $orden, $dir) !!}</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($facturas as $f)
                <tr>
                    <td><strong>{{ $f->numero_factura }}</strong></td>
                    <td>{{ $f->paciente->nombre_completo ?? '—' }}</td>
                    <td>{{ $f->pagado_en ? \Carbon\Carbon::parse($f->pagado_en)->format('d/m/Y H:i') : '—' }}</td>
                    <td>
                        @if($f->pagado_en)
                            <span class="badge bg-success">Pagada</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('facturas.edit', $f) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('facturas.destroy', $f) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta factura?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay facturas registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">{{ $facturas->total() }} resultado(s)</small>
    {{ $facturas->links() }}
</div>
@endsection
