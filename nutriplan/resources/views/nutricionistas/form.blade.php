@extends('layouts.app')
@section('titulo', isset($nutricionista) ? 'Editar nutricionista' : 'Nuevo nutricionista')

@section('contenido')
<div class="mb-4">
    <h2><i class="bi bi-person-badge me-2 text-success"></i>
        {{ isset($nutricionista) ? 'Editar nutricionista' : 'Nuevo nutricionista' }}
    </h2>
</div>

<div class="card shadow-sm" style="max-width:600px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ isset($nutricionista) ? route('nutricionistas.update', $nutricionista) : route('nutricionistas.store') }}"
              method="POST">
            @csrf
            @if(isset($nutricionista)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Tienda <span class="text-danger">*</span></label>
                <select name="tienda_id" class="form-select @error('tienda_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($tiendas as $t)
                        <option value="{{ $t->id }}" @selected(old('tienda_id', $nutricionista->tienda_id ?? '') == $t->id)>
                            {{ $t->nombre_tienda }}
                        </option>
                    @endforeach
                </select>
                @error('tienda_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror"
                       value="{{ old('nombre_completo', $nutricionista->nombre_completo ?? '') }}" required>
                @error('nombre_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Especialidad <span class="text-danger">*</span></label>
                <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror"
                       value="{{ old('especialidad', $nutricionista->especialidad ?? '') }}" required>
                @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ciudad <span class="text-danger">*</span></label>
                <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
                       value="{{ old('ciudad', $nutricionista->ciudad ?? '') }}" required>
                @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Valoración media (0–5) <span class="text-danger">*</span></label>
                <input type="number" name="valoracion_media" step="0.1" min="0" max="5"
                       class="form-control @error('valoracion_media') is-invalid @enderror"
                       value="{{ old('valoracion_media', $nutricionista->valoracion_media ?? '0') }}" required>
                @error('valoracion_media')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($nutricionista) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('nutricionistas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
