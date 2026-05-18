@extends('layouts.app')
@section('titulo','Pacientes')
@section('breadcrumb','Pacientes')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-success"></i>Pacientes</h4>
    @if(Auth::user()->esAdmin())
        <a href="{{ route('pacientes.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg me-1"></i>Nuevo paciente</a>
    @endif
</div>

<form method="GET" action="{{ route('pacientes.index') }}" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Buscar por nombre..." value="{{ request('buscar') }}">
            </div>
            @if(Auth::user()->esAdmin())
            <div class="col-md-3">
                <select name="nutricionista_id" class="form-select form-select-sm">
                    <option value="">Todos los nutricionistas</option>
                    @foreach($nutricionistas as $n)
                        <option value="{{ $n->id }}" @selected(request('nutricionista_id')==$n->id)>{{ $n->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-2">
                <input type="text" name="ciudad" class="form-control form-control-sm" placeholder="Ciudad..." value="{{ request('ciudad') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-auto">
                <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
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
                    <th>Nombre</th>
                    <th>Nutricionista</th>
                    <th>Ciudad</th>
                    <th>Objetivos</th>
                    <th>Cuenta</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pacientes as $p)
                <tr>
                    <td class="fw-semibold">
                        @if($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}" class="rounded-circle me-2" style="width:30px;height:30px;object-fit:cover">
                        @endif
                        {{ $p->nombre_completo }}
                    </td>
                    <td class="text-muted small">{{ $p->nutricionista?->nombre_completo ?? '—' }}</td>
                    <td class="text-muted small">{{ $p->ciudad ?? '—' }}</td>
                    <td class="text-muted small">{{ \Illuminate\Support\Str::limit($p->objetivos ?? '—', 30) }}</td>
                    <td>
                        @if($p->user)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">Tiene acceso</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 small">Sin acceso</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('pacientes.show',$p) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('pacientes.edit',$p) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        @if(Auth::user()->esAdmin())
                        <form action="{{ route('pacientes.destroy',$p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar a {{ $p->nombre_completo }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay pacientes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $pacientes->links() }}</div>
@endsection
