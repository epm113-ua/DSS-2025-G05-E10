@extends('layouts.app')
@section('titulo','Crear usuario')
@section('breadcrumb','Admin › Usuarios › Crear')
@section('contenido')
<h4 class="fw-bold mb-4"><i class="bi bi-person-plus me-2 text-success"></i>Crear nuevo usuario</h4>
<div class="card" style="max-width:560px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Nombre completo <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Correo electrónico <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Contraseña <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Rol <span class="text-danger">*</span></label>
                <select name="rol" class="form-select @error('rol') is-invalid @enderror" id="rolSelect" required>
                    <option value="">— Seleccionar —</option>
                    <option value="admin"         @selected(old('rol')=='admin')>Administrador</option>
                    <option value="nutricionista" @selected(old('rol')=='nutricionista')>Nutricionista</option>
                    <option value="paciente"      @selected(old('rol')=='paciente')>Paciente</option>
                </select>
                @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4" id="nutricionistaSelect" style="display:none">
                <label class="form-label fw-semibold small">Nutricionista asignado</label>
                <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror">
                    <option value="">— Seleccionar —</option>
                    @foreach($nutricionistas as $n)
                        <option value="{{ $n->id }}" @selected(old('nutricionista_id')==$n->id)>{{ $n->nombre_completo }} — {{ $n->especialidad }}</option>
                    @endforeach
                </select>
                @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Crear usuario</button>
                <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.getElementById('rolSelect').addEventListener('change', function() {
    document.getElementById('nutricionistaSelect').style.display = this.value === 'paciente' ? '' : 'none';
});
</script>
@endsection
