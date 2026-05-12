@extends('layouts.app')
@section('titulo', 'Facturas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-receipt me-2 text-success"></i>Facturas</h2>
    <a href="{{ route('facturas.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva factura
    </a>
</div>

<form method="GET" action="{{ route('facturas.index') }}" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="buscar" class="form-control" placeholder="Número de factura..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" @selected(request('estado')==='pendiente')>Pendientes</option>
                    <option value="pagada"    @selected(request('estado')==='pagada')>Pagadas</option>
                </select>
            </div>
            @isset($pacientes)
            <div class="col-md-3">
                <select name="paciente_id" class="form-select">
                    <option value="">Todos los pacientes</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(request('paciente_id') == $p->id)>{{ $p->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            @endisset
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
        </div>
        <input type="hidden" name="orden" value="{{ $orden }}">
        <input type="hidden" name="dir" value="{{ $dir }}">
    </div>
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
                    <td>{{ $f->pagado_en?->format('d/m/Y H:i') ?? '—' }}</td>
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
<div class="mt-3">
    {{ $facturas->links() }}
</div>
@endsection
