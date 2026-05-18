@extends('layouts.app')
@section('titulo', isset($nutricionista) ? 'Editar nutricionista' : 'Nuevo nutricionista')
@section('breadcrumb', isset($nutricionista) ? 'Nutricionistas › Editar' : 'Nutricionistas › Nuevo')
@section('contenido')
<h4 class="fw-bold mb-4"><i class="bi bi-person-badge me-2 text-success"></i>{{ isset($nutricionista) ? 'Editar nutricionista' : 'Nuevo nutricionista' }}</h4>
<div class="card" style="max-width:620px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ isset($nutricionista) ? route('nutricionistas.update',$nutricionista) : route('nutricionistas.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($nutricionista))
                @method('PUT')
            @endif

            @if(isset($nutricionista) && $nutricionista->foto)
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/'.$nutricionista->foto) }}" class="rounded-circle" style="width:80px;height:80px;object-fit:cover" alt="Foto">
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold small">Foto de perfil</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Tienda</label>
                <select name="tienda_id" class="form-select @error('tienda_id') is-invalid @enderror">
                    <option value="">— Sin tienda asignada —</option>
                    @foreach($tiendas as $t)
                        <option value="{{ $t->id }}" @selected(old('tienda_id',$nutricionista->tienda_id ?? '') == $t->id)>{{ $t->nombre_tienda }}</option>
                    @endforeach
                </select>
                @error('tienda_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Nombre completo <span class="text-danger">*</span></label>
                <input type="text" name="nombre_completo" class="form-control @error('nombre_completo') is-invalid @enderror"
                       value="{{ old('nombre_completo',$nutricionista->nombre_completo ?? '') }}" required>
                @error('nombre_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Especialidad <span class="text-danger">*</span></label>
                <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror"
                       value="{{ old('especialidad',$nutricionista->especialidad ?? '') }}" required>
                @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-7">
                    <label class="form-label fw-semibold small">Ciudad <span class="text-danger">*</span></label>
                    <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
                           value="{{ old('ciudad',$nutricionista->ciudad ?? '') }}" required>
                    @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-5">
                    <label class="form-label fw-semibold small">Valoración (0-5) <span class="text-danger">*</span></label>
                    <input type="number" name="valoracion_media" step="0.1" min="0" max="5"
                           class="form-control @error('valoracion_media') is-invalid @enderror"
                           value="{{ old('valoracion_media',$nutricionista->valoracion_media ?? '0') }}" required>
                    @error('valoracion_media')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            @if(!isset($nutricionista))
            <hr class="my-3">
            <p class="small text-muted mb-2"><i class="bi bi-key me-1"></i>Credenciales de acceso <span class="text-muted">(opcional)</span></p>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres">
            </div>
            @else
                @if($nutricionista->user)
                    <div class="alert alert-info small py-2 mt-3"><i class="bi bi-person-check me-1"></i>Usuario vinculado: <strong>{{ $nutricionista->user->email }}</strong></div>
                @else
                    <div class="alert alert-warning small py-2 mt-3"><i class="bi bi-exclamation-triangle me-1"></i>Sin cuenta de acceso.</div>
                @endif
            @endif

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>{{ isset($nutricionista) ? 'Guardar cambios' : 'Crear nutricionista' }}</button>
                <a href="{{ route('nutricionistas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
