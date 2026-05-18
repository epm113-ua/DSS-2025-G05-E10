@extends('layouts.app')
@section('titulo','Pagos')
@section('breadcrumb','Pagos')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-credit-card me-2 text-success"></i>Pagos</h4>
    <a href="{{ route('pagos.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg me-1"></i>Nuevo pago</a>
</div>

<form method="GET" action="{{ route('pagos.index') }}" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Titular o nº factura..." value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <select name="forma_pago" class="form-select form-select-sm">
                    <option value="">Todas las formas</option>
                    @foreach($formas as $f)
                        <option value="{{ $f }}" @selected(request('forma_pago')==$f)>{{ $f }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
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
                    <th>Factura</th>
                    <th>Titular</th>
                    <th>Importe</th>
                    <th>Forma de pago</th>
                    <th>Fecha</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pagos as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->factura->numero_factura ?? '—' }}</td>
                    <td>{{ $p->nombre_titular }}</td>
                    <td class="fw-semibold text-success">{{ number_format($p->importe,2) }} €</td>
                    <td><span class="badge bg-info text-dark">{{ $p->forma_pago }}</span></td>
                    <td>{{ $p->fecha_pago->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('pagos.edit',$p) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('pagos.destroy',$p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este pago?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay pagos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $pagos->links() }}</div>
@endsection
