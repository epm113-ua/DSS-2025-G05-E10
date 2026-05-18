<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NutriPlan') — Nutrición personalizada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --verde: #2e7d52; --verde-dark: #1e5e38; }
        .navbar-brand span { color: var(--verde); font-weight: 700; }
        .btn-verde { background: var(--verde); color: #fff; border: none; }
        .btn-verde:hover { background: var(--verde-dark); color: #fff; }
        footer { background: #1a3d2b; color: #c8e6c9; }
        footer a { color: #a5d6a7; }
    </style>
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('inicio') }}">
            <i class="bi bi-flower1 text-success"></i> <span>NutriPlan</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublico">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navPublico">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('inicio') ? 'active fw-semibold' : '' }}" href="{{ route('inicio') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('sobre') ? 'active fw-semibold' : '' }}" href="{{ route('sobre') }}">Sobre nosotros</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contacto') ? 'active fw-semibold' : '' }}" href="{{ route('contacto') }}">Contacto</a></li>
            </ul>
            <div class="d-flex gap-2">
                @auth
                    <a href="{{ Auth::user()->rutaInicio() }}" class="btn btn-verde btn-sm rounded-pill px-3">Mi panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-verde btn-sm rounded-pill px-3">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="py-4 mt-5">
    <div class="container text-center">
        <p class="mb-1"><strong class="text-white"><i class="bi bi-flower1"></i> NutriPlan</strong></p>
        <p class="small mb-0">&copy; {{ date('Y') }} NutriPlan. Nutrición personalizada.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
