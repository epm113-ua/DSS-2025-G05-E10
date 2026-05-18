@extends('layouts.auth')
@section('title', 'Nueva contraseña')

@section('content')
<h5 class="fw-bold mb-4 text-center">Establecer nueva contraseña</h5>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-3">
        <label class="form-label small fw-semibold">Correo electrónico</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ $email ?? old('email') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label small fw-semibold">Nueva contraseña</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <label class="form-label small fw-semibold">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Restablecer contraseña</button>
</form>
@endsection
