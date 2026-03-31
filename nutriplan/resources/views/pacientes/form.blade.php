@extends('layouts.app')
@section('titulo', isset($paciente) ? 'Editar paciente' : 'Nuevo paciente')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-people me-2 text-success"></i>
    {{ isset($paciente) ? 'Editar paciente' : 'Nuevo paciente' }}
</h2>
<div class="card shadow-sm" style="max-width:600px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($paciente) ? route('pacientes.update', $paciente) : route('pacientes.store') }}" method="POST">
            @csrf
            @if(isset($paciente)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Nutricionista <span class="text-danger">*</span></label>
                <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($nutricionistas as $n)
                        <option value="{{ $n->id }}" @selected(old('nutricionista_id', $paciente->nutricionista_id ?? '') == $n->id)>
                            {{ $n->nombre_completo }}
                        </option>
                    @endforeach
                </select>
                @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror"
                       value="{{ old('nombre_completo', $paciente->nombre_completo ?? '') }}" required>
                @error('nombre_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fecha de nacimiento <span class="text-danger">*</span></label>
                <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                       value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento ?? '') }}" required>
                @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ciudad <span class="text-danger">*</span></label>
                <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
                       value="{{ old('ciudad', $paciente->ciudad ?? '') }}" required>
                @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Objetivos <span class="text-danger">*</span></label>
                <textarea name="objetivos" rows="3" class="form-control @error('objetivos') is-invalid @enderror"
                          required>{{ old('objetivos', $paciente->objetivos ?? '') }}</textarea>
                @error('objetivos')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($paciente) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
