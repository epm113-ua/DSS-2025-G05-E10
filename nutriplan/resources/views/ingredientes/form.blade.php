@extends('layouts.app')
@section('titulo', isset($ingrediente) ? 'Editar ingrediente' : 'Nuevo ingrediente')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-basket me-2 text-success"></i>
    {{ isset($ingrediente) ? 'Editar ingrediente' : 'Nuevo ingrediente' }}
</h2>
<div class="card shadow-sm" style="max-width:480px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($ingrediente) ? route('ingredientes.update', $ingrediente) : route('ingredientes.store') }}" method="POST">
            @csrf
            @if(isset($ingrediente)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Tienda <span class="text-danger">*</span></label>
                <select name="tienda_id" class="form-select @error('tienda_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($tiendas as $t)
                        <option value="{{ $t->id }}" @selected(old('tienda_id', $ingrediente->tienda_id ?? '') == $t->id)>
                            {{ $t->nombre_tienda }}
                        </option>
                    @endforeach
                </select>
                @error('tienda_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $ingrediente->nombre ?? '') }}" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($ingrediente) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('ingredientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
