@extends('layouts.auth')
@section('title', 'Recuperar contraseña')

@section('content')
<h5 class="fw-bold mb-1 text-center">Recuperar contraseña</h5>
<p class="text-muted small text-center mb-4">Te enviaremos un enlace para restablecerla.</p>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label small fw-semibold">Correo electrónico</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Enviar enlace</button>
</form>
<div class="text-center mt-3">
    <a href="{{ route('login') }}" class="small brand-color">Volver al login</a>
</div>
@endsection
