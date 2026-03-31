@extends('layouts.app')
@section('titulo', isset($tienda) ? 'Editar tienda' : 'Nueva tienda')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-shop me-2 text-success"></i>
    {{ isset($tienda) ? 'Editar tienda' : 'Nueva tienda' }}
</h2>
<div class="card shadow-sm" style="max-width:480px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($tienda) ? route('tiendas.update', $tienda) : route('tiendas.store') }}" method="POST">
            @csrf
            @if(isset($tienda)) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la tienda <span class="text-danger">*</span></label>
                <input type="text" name="nombre_tienda" class="form-control @error('nombre_tienda') is-invalid @enderror"
                       value="{{ old('nombre_tienda', $tienda->nombre_tienda ?? '') }}" required>
                @error('nombre_tienda')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($tienda) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('tiendas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
