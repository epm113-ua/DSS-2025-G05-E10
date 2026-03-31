@extends('layouts.app')
@section('titulo', isset($ofertaIngrediente) ? 'Editar oferta' : 'Nueva oferta')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-tag me-2 text-success"></i>
    {{ isset($ofertaIngrediente) ? 'Editar oferta' : 'Nueva oferta' }}
</h2>
<div class="card shadow-sm" style="max-width:560px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($ofertaIngrediente) ? route('oferta-ingredientes.update', $ofertaIngrediente) : route('oferta-ingredientes.store') }}" method="POST">
            @csrf
            @if(isset($ofertaIngrediente)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Ingrediente <span class="text-danger">*</span></label>
                <select name="ingrediente_id" class="form-select @error('ingrediente_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($ingredientes as $i)
                        <option value="{{ $i->id }}" @selected(old('ingrediente_id', $ofertaIngrediente->ingrediente_id ?? '') == $i->id)>
                            {{ $i->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('ingrediente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tienda <span class="text-danger">*</span></label>
                <select name="tienda_id" class="form-select @error('tienda_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($tiendas as $t)
                        <option value="{{ $t->id }}" @selected(old('tienda_id', $ofertaIngrediente->tienda_id ?? '') == $t->id)>
                            {{ $t->nombre_tienda }}
                        </option>
                    @endforeach
                </select>
                @error('tienda_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de la oferta <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $ofertaIngrediente->nombre ?? '') }}" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                <textarea name="descripcion_oferta" rows="3" class="form-control @error('descripcion_oferta') is-invalid @enderror"
                          required>{{ old('descripcion_oferta', $ofertaIngrediente->descripcion_oferta ?? '') }}</textarea>
                @error('descripcion_oferta')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($ofertaIngrediente) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('oferta-ingredientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
