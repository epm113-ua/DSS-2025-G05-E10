@extends('layouts.app')
@section('titulo', isset($paciente) ? 'Editar paciente' : 'Nuevo paciente')
@section('breadcrumb', isset($paciente) ? 'Pacientes › Editar' : 'Pacientes › Nuevo')
@section('contenido')
<h4 class="fw-bold mb-4"><i class="bi bi-people me-2 text-success"></i>{{ isset($paciente) ? 'Editar paciente' : 'Nuevo paciente' }}</h4>
<div class="card" style="max-width:620px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ isset($paciente) ? route('pacientes.update',$paciente) : route('pacientes.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($paciente)) @method('PUT') @endif

            {{-- Foto solo visible para admin --}}
            @if(Auth::user()->esAdmin())
                @if(isset($paciente) && $paciente->foto)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/'.$paciente->foto) }}" class="rounded-circle"
                             style="width:72px;height:72px;object-fit:cover">
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Foto de perfil</label>
                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            @else
                {{-- El paciente aparece con su foto actual (solo lectura) --}}
                @if(isset($paciente) && $paciente->foto)
                    <div class="d-flex align-items-center gap-3 mb-3 p-2 bg-light rounded">
                        <img src="{{ asset('storage/'.$paciente->foto) }}" class="rounded-circle"
                             style="width:48px;height:48px;object-fit:cover">
                        <span class="text-muted small">La foto solo puede cambiarse por el propio paciente desde su perfil.</span>
                    </div>
                @endif
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold small">Nutricionista asignado <span class="text-danger">*</span></label>
                @if(isset($paciente))
                    <input type="text" class="form-control" value="{{ $paciente->nutricionista?->nombre_completo }}" disabled>
                    <div class="form-text">La asignación de nutricionista no puede cambiarse.</div>
                @else
                    <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror" required>
                        <option value="">— Seleccionar —</option>
                        @foreach($nutricionistas as $n)
                            <option value="{{ $n->id }}" @selected(old('nutricionista_id')==$n->id)>{{ $n->nombre_completo }} — {{ $n->especialidad }}</option>
                        @endforeach
                    </select>
                    @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Nombre completo <span class="text-danger">*</span></label>
                <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror"
                       value="{{ old('nombre_completo',$paciente->nombre_completo ?? '') }}" required>
                @error('nombre_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold small">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                           value="{{ old('fecha_nacimiento', isset($paciente) ? $paciente->fecha_nacimiento?->format('Y-m-d') : '') }}">
                    @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold small">Ciudad</label>
                    <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
                           value="{{ old('ciudad',$paciente->ciudad ?? '') }}">
                    @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Objetivos</label>
                <textarea name="objetivos" class="form-control @error('objetivos') is-invalid @enderror" rows="2">{{ old('objetivos',$paciente->objetivos ?? '') }}</textarea>
                @error('objetivos')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            @if(!isset($paciente) && Auth::user()->esAdmin())
            <hr class="my-3">
            <p class="small text-muted mb-2"><i class="bi bi-key me-1"></i>Credenciales de acceso <span class="text-muted">(opcional)</span></p>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres">
            </div>
            @elseif(isset($paciente))
                @if($paciente->user)
                    <div class="alert alert-info small py-2 mt-3"><i class="bi bi-person-check me-1"></i>Usuario vinculado: <strong>{{ $paciente->user->email }}</strong></div>
                @else
                    <div class="alert alert-warning small py-2 mt-3"><i class="bi bi-exclamation-triangle me-1"></i>Sin cuenta de acceso.</div>
                @endif
            @endif

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>{{ isset($paciente) ? 'Guardar cambios' : 'Crear paciente' }}</button>
                <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
