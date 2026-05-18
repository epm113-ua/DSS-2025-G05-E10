@extends('layouts.publico')
@section('title', 'Contacto')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:640px">
        <h1 class="fw-bold mb-2 text-success">Contacto</h1>
        <p class="text-muted mb-4">¿Tienes dudas? Escríbenos y te responderemos lo antes posible.</p>

        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif

        <div class="card border-0 shadow-sm p-4">
            <form method="POST" action="{{ route('contacto.enviar') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small">Mensaje</label>
                    <textarea name="mensaje" rows="5" class="form-control @error('mensaje') is-invalid @enderror" required>{{ old('mensaje') }}</textarea>
                    @error('mensaje')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-success w-100 py-2 fw-semibold rounded-pill">Enviar mensaje</button>
            </form>
        </div>
    </div>
</section>
@endsection
