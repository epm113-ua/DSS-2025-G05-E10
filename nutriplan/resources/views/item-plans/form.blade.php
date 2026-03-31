@extends('layouts.app')
@section('titulo', isset($itemPlan) ? 'Editar ítem de plan' : 'Nuevo ítem de plan')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-list-check me-2 text-success"></i>
    {{ isset($itemPlan) ? 'Editar ítem de plan' : 'Nuevo ítem de plan' }}
</h2>
<div class="card shadow-sm" style="max-width:560px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($itemPlan) ? route('item-plans.update', $itemPlan) : route('item-plans.store') }}" method="POST">
            @csrf
            @if(isset($itemPlan)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Plan semanal <span class="text-danger">*</span></label>
                <select name="plan_semanal_id" class="form-select @error('plan_semanal_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($planes as $p)
                        <option value="{{ $p->id }}" @selected(old('plan_semanal_id', $itemPlan->plan_semanal_id ?? '') == $p->id)>
                            #{{ $p->id }} – {{ $p->semana_inicio }} ({{ $p->cita->paciente->nombre_completo ?? '' }})
                        </option>
                    @endforeach
                </select>
                @error('plan_semanal_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Receta <span class="text-danger">*</span></label>
                <select name="receta_id" class="form-select @error('receta_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($recetas as $r)
                        <option value="{{ $r->id }}" @selected(old('receta_id', $itemPlan->receta_id ?? '') == $r->id)>
                            {{ $r->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('receta_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Día de la semana <span class="text-danger">*</span></label>
                    <select name="dia_semana" class="form-select @error('dia_semana') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($diasSemana as $num => $nombre)
                            <option value="{{ $num }}" @selected(old('dia_semana', $itemPlan->dia_semana ?? '') == $num)>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('dia_semana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo de comida <span class="text-danger">*</span></label>
                    <select name="tipo_comida" class="form-select @error('tipo_comida') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($tiposComida as $tipo)
                            <option value="{{ $tipo }}" @selected(old('tipo_comida', $itemPlan->tipo_comida ?? '') === $tipo)>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_comida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Notas</label>
                <textarea name="notas" rows="2" class="form-control @error('notas') is-invalid @enderror">{{ old('notas', $itemPlan->notas ?? '') }}</textarea>
                @error('notas')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($itemPlan) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('item-plans.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
