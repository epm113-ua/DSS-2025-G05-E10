@extends('layouts.app')
@section('titulo','Mi Perfil')
@section('breadcrumb','Mi Perfil')
@section('contenido')
<h4 class="fw-bold mb-4">Mi Perfil</h4>
<div class="row g-4" style="max-width:800px">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-person-badge me-1"></i>Datos profesionales</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('nutricionista.mi-perfil.update') }}" enctype="multipart/form-data">
                    @csrf

                    @if($nutricionista->foto)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/'.$nutricionista->foto) }}?v={{ time() }}" class="rounded-circle"
                                 style="width:80px;height:80px;object-fit:cover" alt="Foto">
                        </div>
                    @else
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center fw-bold mx-auto"
                                 style="width:80px;height:80px;font-size:1.6rem">
                                {{ strtoupper(substr($nutricionista->nombre_completo,0,1)) }}{{ strtoupper(substr(strstr($nutricionista->nombre_completo,' '),1,1)) }}
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Foto de perfil</label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror"
                               value="{{ old('nombre_completo', $nutricionista->nombre_completo) }}" required>
                        @error('nombre_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Especialidad <span class="text-danger">*</span></label>
                        <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror"
                               value="{{ old('especialidad', $nutricionista->especialidad) }}" required>
                        @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ciudad <span class="text-danger">*</span></label>
                        <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
                               value="{{ old('ciudad', $nutricionista->ciudad) }}" required>
                        @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Correo electrónico</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                        <div class="form-text">El email no puede cambiarse aquí.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Valoración</label>
                        <div class="d-flex align-items-center gap-2">
                            @for($i=1; $i<=5; $i++)
                                <i class="bi bi-star{{ $i <= $nutricionista->valoracion_media ? '-fill' : '' }} text-warning fs-5"></i>
                            @endfor
                            <span class="text-muted small ms-1">{{ number_format($nutricionista->valoracion_media,1) }} / 5</span>
                        </div>
                        <div class="form-text">La valoración la gestiona el administrador.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5 d-flex flex-column gap-3">
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-people me-1"></i>Mis pacientes</div>
            <div class="card-body text-center py-3">
                <div class="fs-2 fw-bold text-success">{{ $nutricionista->pacientes()->count() }}</div>
                <div class="text-muted small">pacientes asignados</div>
                <a href="{{ route('pacientes.index') }}" class="btn btn-outline-success btn-sm mt-2">Ver pacientes</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-shop me-1"></i>Tienda asignada</div>
            <div class="card-body text-center py-3">
                <div class="fw-semibold">{{ $nutricionista->tienda?->nombre_tienda ?? 'Sin tienda asignada' }}</div>
                <div class="text-muted small mt-1">{{ $nutricionista->ciudad }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
