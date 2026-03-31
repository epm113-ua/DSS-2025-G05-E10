@extends('layouts.app')
@section('titulo', isset($medicion) ? 'Editar medición' : 'Nueva medición')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-activity me-2 text-success"></i>
    {{ isset($medicion) ? 'Editar medición' : 'Nueva medición' }}
</h2>
<div class="card shadow-sm" style="max-width:560px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($medicion) ? route('mediciones.update', $medicion) : route('mediciones.store') }}" method="POST">
            @csrf
            @if(isset($medicion)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Paciente <span class="text-danger">*</span></label>
                <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(old('paciente_id', $medicion->paciente_id ?? '') == $p->id)>
                            {{ $p->nombre_completo }}
                        </option>
                    @endforeach
                </select>
                @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fecha de medición <span class="text-danger">*</span></label>
                <input type="date" name="fecha_medicion" class="form-control @error('fecha_medicion') is-invalid @enderror"
                       value="{{ old('fecha_medicion', $medicion->fecha_medicion ?? '') }}" required>
                @error('fecha_medicion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Peso (kg) <span class="text-danger">*</span></label>
                    <input type="number" name="peso_kg" min="1" max="500" step="0.01"
                           class="form-control @error('peso_kg') is-invalid @enderror"
                           value="{{ old('peso_kg', $medicion->peso_kg ?? '') }}" required>
                    @error('peso_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Altura (cm) <span class="text-danger">*</span></label>
                    <input type="number" name="altura_cm" min="50" max="250"
                           class="form-control @error('altura_cm') is-invalid @enderror"
                           value="{{ old('altura_cm', $medicion->altura_cm ?? '') }}" required>
                    @error('altura_cm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">% Grasa</label>
                    <input type="number" name="porcentaje_grasa" min="0" max="100" step="0.01"
                           class="form-control @error('porcentaje_grasa') is-invalid @enderror"
                           value="{{ old('porcentaje_grasa', $medicion->porcentaje_grasa ?? '') }}">
                    @error('porcentaje_grasa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($medicion) ? 'Guardar cambios' : 'Registrar' }}
                </button>
                <a href="{{ route('mediciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
