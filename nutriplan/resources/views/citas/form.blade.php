@extends('layouts.app')
@section('titulo', isset($cita) ? 'Editar cita' : 'Nueva cita')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-calendar-check me-2 text-success"></i>
    {{ isset($cita) ? 'Editar cita' : 'Nueva cita' }}
</h2>
<div class="card shadow-sm" style="max-width:620px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($cita) ? route('citas.update', $cita) : route('citas.store') }}" method="POST">
            @csrf
            @if(isset($cita)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nutricionista <span class="text-danger">*</span></label>
                    <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($nutricionistas as $n)
                            <option value="{{ $n->id }}" @selected(old('nutricionista_id', $cita->nutricionista_id ?? '') == $n->id)>
                                {{ $n->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Paciente <span class="text-danger">*</span></label>
                    <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($pacientes as $p)
                            <option value="{{ $p->id }}" @selected(old('paciente_id', $cita->paciente_id ?? '') == $p->id)>
                                {{ $p->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Inicio <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="inicio" class="form-control @error('inicio') is-invalid @enderror"
                           value="{{ old('inicio', isset($cita) ? \Carbon\Carbon::parse($cita->inicio)->format('Y-m-d\TH:i') : '') }}" required>
                    @error('inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fin <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="fin" class="form-control @error('fin') is-invalid @enderror"
                           value="{{ old('fin', isset($cita) ? \Carbon\Carbon::parse($cita->fin)->format('Y-m-d\TH:i') : '') }}" required>
                    @error('fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                    <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        @foreach(['pendiente', 'completada', 'cancelada'] as $estado)
                            <option value="{{ $estado }}" @selected(old('estado', $cita->estado ?? 'pendiente') === $estado)>
                                {{ ucfirst($estado) }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Motivo <span class="text-danger">*</span></label>
                    <input type="text" name="motivo" class="form-control @error('motivo') is-invalid @enderror"
                           value="{{ old('motivo', $cita->motivo ?? '') }}" required>
                    @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($cita) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
