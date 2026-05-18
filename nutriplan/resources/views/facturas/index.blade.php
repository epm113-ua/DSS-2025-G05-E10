@extends('layouts.app')
@section('titulo', 'Facturas')
@section('breadcrumb', 'Facturas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-success"></i>Facturas</h4>
    <a href="{{ route('facturas.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg me-1"></i>Nueva factura</a>
</div>

<form method="GET" action="{{ route('facturas.index') }}" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Nº factura..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <select name="paciente_id" class="form-select form-select-sm">
                    <option value="">Todos los pacientes</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(request('paciente_id') == $p->id)>{{ $p->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="estado" class="form-select form-select-sm">
                    <option value="">Todos los estados</option>
                    <option value="pagada"   @selected(request('estado')=='pagada')>Pagada</option>
                    <option value="pendiente"@selected(request('estado')=='pendiente')>Pendiente</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
            </div>
        </div>
        <input type="hidden" name="orden" value="{{ $orden }}">
        <input type="hidden" name="dir"   value="{{ $dir }}">
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Nº Factura</th>
                    <th>Paciente</th>
                    <th>Importe</th>
                    <th>Estado</th>
                    <th>Pagado el</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $f)
                <tr>
                    <td class="fw-semibold">{{ $f->numero_factura }}</td>
                    <td>{{ $f->paciente->nombre_completo ?? '—' }}</td>
                    <td class="fw-semibold">{{ number_format($f->importe,2) }} €</td>
                    <td>
                        @if($f->pagado_en)
                            <span class="badge bg-success">Pagada</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                    <td>{{ $f->pagado_en ? $f->pagado_en->format('d/m/Y H:i') : '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('facturas.edit',$f) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('facturas.destroy',$f) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta factura?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay facturas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $facturas->links() }}</div>
@endsection
