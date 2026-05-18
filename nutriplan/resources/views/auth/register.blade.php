@extends('layouts.auth')
@section('title', 'Crear cuenta')

@section('content')
<h5 class="card-title text-center fw-bold mb-1">Crear cuenta</h5>
<p class="text-center text-muted small mb-4">Elige tu rol para comenzar</p>

<form method="POST" action="{{ route('register') }}" id="regForm">
@csrf

{{-- Selector de rol --}}
<div class="d-flex gap-2 mb-4">
    <input type="radio" class="btn-check" name="rol" id="rolPaciente" value="paciente" checked>
    <label class="btn btn-outline-success w-50 py-2" for="rolPaciente">
        <i class="bi bi-person d-block fs-4 mb-1"></i> Paciente
    </label>
    <input type="radio" class="btn-check" name="rol" id="rolNutri" value="nutricionista">
    <label class="btn btn-outline-success w-50 py-2" for="rolNutri">
        <i class="bi bi-person-badge d-block fs-4 mb-1"></i> Nutricionista
    </label>
</div>

{{-- Campos comunes --}}
<div class="mb-3">
    <label class="form-label small fw-semibold">Nombre completo</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name') }}" required autofocus>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label small fw-semibold">Correo electrónico</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

{{-- Solo paciente: selector nutricionista --}}
<div id="seccionPaciente">
    <div class="mb-3">
        <label class="form-label small fw-semibold">Tu nutricionista</label>
        <select name="nutricionista_id" class="form-select @error('nutricionista_id') is-invalid @enderror">
            <option value="">— Selecciona un nutricionista —</option>
            @foreach($nutricionistas as $n)
            <option value="{{ $n->id }}" {{ old('nutricionista_id') == $n->id ? 'selected' : '' }}>
                {{ $n->nombre_completo }} — {{ $n->especialidad }} ({{ $n->ciudad }})
            </option>
            @endforeach
        </select>
        @error('nutricionista_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Esta asignación no podrá cambiarse después.</div>
    </div>
</div>

{{-- Solo nutricionista: especialidad + ciudad --}}
<div id="seccionNutri" style="display:none">
    <div class="mb-3">
        <label class="form-label small fw-semibold">Especialidad</label>
        <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror"
               value="{{ old('especialidad') }}" placeholder="Ej: Nutrición Deportiva">
        @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label small fw-semibold">Ciudad</label>
        <input type="text" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror"
               value="{{ old('ciudad') }}" placeholder="Ej: Madrid">
        @error('ciudad')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label small fw-semibold">Contraseña</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-4">
    <label class="form-label small fw-semibold">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" class="form-control" required>
</div>

<button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Crear cuenta</button>
</form>

<hr class="my-3">
<p class="text-center small text-muted">
    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="brand-color fw-semibold">Inicia sesión</a>
</p>

<script>
document.querySelectorAll('input[name="rol"]').forEach(r => {
    r.addEventListener('change', function() {
        const esNutri = this.value === 'nutricionista';
        document.getElementById('seccionNutri').style.display   = esNutri ? '' : 'none';
        document.getElementById('seccionPaciente').style.display = esNutri ? 'none' : '';
    });
});
</script>
@endsection
