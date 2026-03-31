@extends('layouts.app')
@section('titulo', isset($planSemanal) ? 'Editar plan semanal' : 'Nuevo plan semanal')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-calendar-week me-2 text-success"></i>
    {{ isset($planSemanal) ? 'Editar plan semanal' : 'Nuevo plan semanal' }}
</h2>
<div class="card shadow-sm" style="max-width:540px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($planSemanal) ? route('plan-semanales.update', $planSemanal) : route('plan-semanales.store') }}" method="POST">
            @csrf
            @if(isset($planSemanal)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Cita <span class="text-danger">*</span></label>
                <select name="cita_id" class="form-select @error('cita_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($citas as $c)
                        <option value="{{ $c->id }}" @selected(old('cita_id', $planSemanal->cita_id ?? '') == $c->id)>
                            #{{ $c->id }} – {{ $c->paciente->nombre_completo ?? '' }} ({{ \Carbon\Carbon::parse($c->inicio)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('cita_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Semana de inicio <span class="text-danger">*</span></label>
                <input type="date" name="semana_inicio" class="form-control @error('semana_inicio') is-invalid @enderror"
                       value="{{ old('semana_inicio', $planSemanal->semana_inicio ?? '') }}" required>
                @error('semana_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Notas</label>
                <textarea name="notas" rows="3" class="form-control @error('notas') is-invalid @enderror">{{ old('notas', $planSemanal->notas ?? '') }}</textarea>
                @error('notas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($planSemanal) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('plan-semanales.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
