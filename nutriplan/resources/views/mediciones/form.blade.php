@extends('layouts.app')
@section('titulo', isset($medicion) ? 'Editar medición' : 'Nueva medición')
@section('breadcrumb', isset($medicion) ? 'Mediciones › Editar' : 'Mediciones › Nueva')
@section('contenido')
<h4 class="fw-bold mb-4"><i class="bi bi-activity me-2 text-success"></i>{{ isset($medicion) ? 'Editar medición' : 'Nueva medición' }}</h4>
<div class="card" style="max-width:560px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        {{-- Usar url() directo para evitar problemas con el parámetro de ruta en español --}}
        <form action="{{ isset($medicion) ? url('/mediciones/'.$medicion->id) : route('mediciones.store') }}" method="POST">
            @csrf
            @if(isset($medicion))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold small">Paciente <span class="text-danger">*</span></label>
                <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                    <option value="">— Seleccionar —</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(old('paciente_id', $medicion->paciente_id ?? '') == $p->id)>{{ $p->nombre_completo }}</option>
                    @endforeach
                </select>
                @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Fecha <span class="text-danger">*</span></label>
                <input type="date" name="fecha_medicion" class="form-control @error('fecha_medicion') is-invalid @enderror"
                       value="{{ old('fecha_medicion', isset($medicion) ? $medicion->fecha_medicion->format('Y-m-d') : date('Y-m-d')) }}" required>
                @error('fecha_medicion')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold small">Peso (kg) <span class="text-danger">*</span></label>
                    <input type="number" name="peso_kg" step="0.1" class="form-control @error('peso_kg') is-invalid @enderror"
                           value="{{ old('peso_kg', $medicion->peso_kg ?? '') }}" required>
                    @error('peso_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold small">Altura (cm) <span class="text-danger">*</span></label>
                    <input type="number" name="altura_cm" class="form-control @error('altura_cm') is-invalid @enderror"
                           value="{{ old('altura_cm', $medicion->altura_cm ?? '') }}" required>
                    @error('altura_cm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">% Grasa corporal</label>
                <input type="number" name="porcentaje_grasa" step="0.1" class="form-control @error('porcentaje_grasa') is-invalid @enderror"
                       value="{{ old('porcentaje_grasa', $medicion->porcentaje_grasa ?? '') }}" placeholder="Opcional">
                @error('porcentaje_grasa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small">Notas</label>
                <textarea name="notas" class="form-control @error('notas') is-invalid @enderror" rows="2">{{ old('notas', $medicion->notas ?? '') }}</textarea>
                @error('notas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>{{ isset($medicion) ? 'Guardar cambios' : 'Registrar medición' }}</button>
                <a href="{{ route('mediciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
