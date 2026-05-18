@extends('layouts.auth')
@section('title', 'Iniciar sesión')

@section('content')
<h5 class="card-title text-center fw-bold mb-4">Iniciar sesión</h5>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-semibold">Correo electrónico</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label small fw-semibold">Contraseña</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Recordarme</label>
        </div>
        <a href="{{ route('password.request') }}" class="small brand-color">¿Olvidaste tu contraseña?</a>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Entrar</button>
</form>

<hr class="my-3">
<p class="text-center small text-muted">
    ¿No tienes cuenta? <a href="{{ route('register') }}" class="brand-color fw-semibold">Regístrate aquí</a>
</p>
@endsection
