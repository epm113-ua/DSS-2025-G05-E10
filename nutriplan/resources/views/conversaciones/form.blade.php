@extends('layouts.app')
@section('titulo', isset($conversacion) ? 'Editar conversación' : 'Nueva conversación')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-chat-dots me-2 text-success"></i>
    {{ isset($conversacion) ? 'Editar conversación' : 'Nueva conversación' }}
</h2>
<div class="card shadow-sm" style="max-width:620px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($conversacion) ? route('conversaciones.update', $conversacion) : route('conversaciones.store') }}" method="POST">
            @csrf
            @if(isset($conversacion)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Paciente <span class="text-danger">*</span></label>
                    <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($pacientes as $p)
                            <option value="{{ $p->id }}" @selected(old('paciente_id', $conversacion->paciente_id ?? '') == $p->id)>
                                {{ $p->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nutricionista <span class="text-danger">*</span></label>
                    <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($nutricionistas as $n)
                            <option value="{{ $n->id }}" @selected(old('nutricionista_id', $conversacion->nutricionista_id ?? '') == $n->id)>
                                {{ $n->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Cita asociada <span class="text-danger">*</span></label>
                    <select name="cita_id" class="form-select @error('cita_id') is-invalid @enderror" required>
                        <option value="">-- Seleccionar --</option>
                        @foreach($citas as $c)
                            <option value="{{ $c->id }}" @selected(old('cita_id', $conversacion->cita_id ?? '') == $c->id)>
                                #{{ $c->id }} – {{ $c->paciente->nombre_completo ?? '' }} ({{ \Carbon\Carbon::parse($c->inicio)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('cita_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Colaboración <span class="text-danger">*</span></label>
                    <input type="text" name="colaboracion" class="form-control @error('colaboracion') is-invalid @enderror"
                           value="{{ old('colaboracion', $conversacion->colaboracion ?? '') }}" required>
                    @error('colaboracion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">% Completado <span class="text-danger">*</span></label>
                    <input type="number" name="porcentaje" min="0" max="100"
                           class="form-control @error('porcentaje') is-invalid @enderror"
                           value="{{ old('porcentaje', $conversacion->porcentaje ?? 0) }}" required>
                    @error('porcentaje')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Mensaje resumen</label>
                    <textarea name="mensaje_resumen" rows="2" class="form-control @error('mensaje_resumen') is-invalid @enderror">{{ old('mensaje_resumen', $conversacion->mensaje_resumen ?? '') }}</textarea>
                    @error('mensaje_resumen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fecha de creación <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="creado_en"
                           class="form-control @error('creado_en') is-invalid @enderror"
                           value="{{ old('creado_en', isset($conversacion) ? \Carbon\Carbon::parse($conversacion->creado_en)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                    @error('creado_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($conversacion) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('conversaciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
