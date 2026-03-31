@extends('layouts.app')
@section('titulo', isset($receta) ? 'Editar receta' : 'Nueva receta')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-journal-richtext me-2 text-success"></i>
    {{ isset($receta) ? 'Editar receta' : 'Nueva receta' }}
</h2>
<div class="card shadow-sm" style="max-width:680px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($receta) ? route('recetas.update', $receta) : route('recetas.store') }}" method="POST">
            @csrf
            @if(isset($receta)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Nutricionista <span class="text-danger">*</span></label>
                <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($nutricionistas as $n)
                        <option value="{{ $n->id }}" @selected(old('nutricionista_id', $receta->nutricionista_id ?? '') == $n->id)>
                            {{ $n->nombre_completo }}
                        </option>
                    @endforeach
                </select>
                @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $receta->nombre ?? '') }}" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Preparación <span class="text-danger">*</span></label>
                <textarea name="preparacion" rows="4" class="form-control @error('preparacion') is-invalid @enderror"
                          required>{{ old('preparacion', $receta->preparacion ?? '') }}</textarea>
                @error('preparacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Calorías (kcal) <span class="text-danger">*</span></label>
                    <input type="number" name="calorias_kcal" min="0" class="form-control @error('calorias_kcal') is-invalid @enderror"
                           value="{{ old('calorias_kcal', $receta->calorias_kcal ?? '') }}" required>
                    @error('calorias_kcal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Carbohidratos (g) <span class="text-danger">*</span></label>
                    <input type="number" name="carbohidratos_g" min="0" step="0.01"
                           class="form-control @error('carbohidratos_g') is-invalid @enderror"
                           value="{{ old('carbohidratos_g', $receta->carbohidratos_g ?? '') }}" required>
                    @error('carbohidratos_g')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Grasas (g) <span class="text-danger">*</span></label>
                    <input type="number" name="grasas_g" min="0" step="0.01"
                           class="form-control @error('grasas_g') is-invalid @enderror"
                           value="{{ old('grasas_g', $receta->grasas_g ?? '') }}" required>
                    @error('grasas_g')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">URL foto (opcional)</label>
                <input type="text" name="ruta_foto" class="form-control @error('ruta_foto') is-invalid @enderror"
                       value="{{ old('ruta_foto', $receta->ruta_foto ?? '') }}">
                @error('ruta_foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            @if($ingredientes->count())
            <div class="mb-3">
                <label class="form-label fw-semibold">Ingredientes</label>
                <div class="border rounded p-2" style="max-height:200px; overflow-y:auto">
                    @foreach($ingredientes as $ing)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ingredientes[]"
                                   value="{{ $ing->id }}" id="ing_{{ $ing->id }}"
                                   @if(in_array($ing->id, old('ingredientes', $ingredientesActivos ?? []))) checked @endif>
                            <label class="form-check-label" for="ing_{{ $ing->id }}">{{ $ing->nombre }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($receta) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
