@extends('layouts.paciente')
@section('title','Mis Facturas')
@section('breadcrumb','Mis Facturas')
@section('contenido')
<h4 class="fw-bold mb-4">Mis Facturas</h4>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr><th>Nº Factura</th><th>Fecha</th><th>Importe</th><th>Estado</th></tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                <tr>
                    <td class="fw-semibold">{{ $factura->numero_factura ?? '#'.$factura->id }}</td>
                    <td>{{ $factura->created_at->format('d/m/Y') }}</td>
                    <td class="fw-semibold">{{ number_format($factura->importe ?? 0,2) }} €</td>
                    <td>
                        @if($factura->pagado_en)
                            <span class="badge bg-success">Pagada</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No tienes facturas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $facturas->links() }}
@endsection
