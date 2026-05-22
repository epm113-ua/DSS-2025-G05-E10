@extends('layouts.paciente')
@section('title','Mi Perfil')
@section('breadcrumb','Mi Perfil')
@section('contenido')
<h4 class="fw-bold mb-4">Mi Perfil</h4>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-person me-1"></i>Datos personales</div>
            <div class="card-body p-4">
                {{-- POST (no PATCH) para compatibilidad con subida de archivos --}}
                <form method="POST" action="{{ route('paciente.mi-perfil.update') }}" enctype="multipart/form-data">
                    @csrf

                    @if($paciente->foto)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/'.$paciente->foto) }}?v={{ time() }}" class="rounded-circle"
                                 style="width:80px;height:80px;object-fit:cover" alt="Foto" id="fotoPreview">
                        </div>
                    @else
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center fw-bold"
                                 style="width:80px;height:80px;font-size:1.6rem" id="fotoPreview">
                                {{ strtoupper(substr($paciente->nombre_completo ?? Auth::user()->name,0,1)) }}{{ strtoupper(substr(strstr($paciente->nombre_completo ?? Auth::user()->name,' '),1,1)) }}
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Foto de perfil</label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre completo</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Correo electrónico</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                        <div class="form-text">El email no puede cambiarse aquí.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento"
                               class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                               value="{{ $paciente->fecha_nacimiento?->format('Y-m-d') }}">
                        @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ciudad</label>
                        <input type="text" name="ciudad"
                               class="form-control @error('ciudad') is-invalid @enderror"
                               value="{{ old('ciudad',$paciente->ciudad) }}">
                        @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Objetivos</label>
                        <textarea name="objetivos"
                                  class="form-control @error('objetivos') is-invalid @enderror"
                                  rows="3">{{ old('objetivos',$paciente->objetivos) }}</textarea>
                        @error('objetivos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-person-badge me-1"></i>Nutricionista asignado/a</div>
            <div class="card-body text-center py-4">
                @if($paciente->nutricionista?->foto)
                    <img src="{{ asset('storage/'.$paciente->nutricionista->foto) }}"
                         class="rounded-circle mb-3" style="width:64px;height:64px;object-fit:cover">
                @else
                    <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:64px;height:64px;font-size:1.5rem;font-weight:700">
                        {{ strtoupper(substr($paciente->nutricionista?->nombre_completo ?? 'N',0,1)) }}
                    </div>
                @endif
                <h6 class="fw-bold mb-1">{{ $paciente->nutricionista?->nombre_completo ?? '—' }}</h6>
                <p class="text-muted small mb-2">{{ $paciente->nutricionista?->especialidad }}</p>
                <span class="badge bg-light text-muted border">
                    <i class="bi bi-lock me-1"></i>Asignación permanente
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
