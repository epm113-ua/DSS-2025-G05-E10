@extends('layouts.app')
@section('titulo', 'Tiendas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-shop me-2 text-success"></i>Tiendas</h2>
    <a href="{{ route('tiendas.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva tienda
    </a>
</div>

<form method="GET" action="{{ route('tiendas.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('tiendas.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-success">
            <tr>
                <th>Nombre</th>
                <th>Nutricionistas</th>
                <th>Ingredientes</th>
                <th>Ofertas</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($tiendas as $t)
                <tr>
                    <td>{{ $t->nombre_tienda }}</td>
                    <td><span class="badge bg-secondary">{{ $t->nutricionistas_count }}</span></td>
                    <td><span class="badge bg-secondary">{{ $t->ingredientes_count }}</span></td>
                    <td><span class="badge bg-secondary">{{ $t->ofertas_count }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('tiendas.edit', $t) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('tiendas.destroy', $t) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta tienda?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay tiendas registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">{{ $tiendas->total() }} resultado(s)</small>
    {{ $tiendas->links() }}
</div>
@endsection
