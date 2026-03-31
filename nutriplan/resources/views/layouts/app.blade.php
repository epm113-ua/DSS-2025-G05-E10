<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan – @yield('titulo', 'Inicio')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #2c7a4b; }
        .sidebar a { color: #d4edda; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background-color: rgba(255,255,255,0.15); border-radius: 6px; }
        .sidebar .nav-link { padding: 0.5rem 1rem; display: block; }
        .sidebar .nav-section { color: #a8d5b5; font-size: 0.75rem; text-transform: uppercase; letter-spacing: .08em; padding: 0.75rem 1rem 0.25rem; }
        .content-area { padding: 2rem; }
        .table-hover tbody tr:hover { background-color: #f0f9f4; }
    </style>
</head>
<body>
<div class="d-flex">
    {{-- Sidebar --}}
    <nav class="sidebar d-flex flex-column p-3" style="width:230px; min-width:230px;">
        <a href="/" class="text-white fs-5 fw-bold mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-heart-pulse-fill"></i> NutriPlan
        </a>
        <hr class="border-success">

        <span class="nav-section">Profesionales</span>
        <a class="nav-link @if(request()->is('nutricionistas*')) active @endif" href="{{ route('nutricionistas.index') }}">
            <i class="bi bi-person-badge me-1"></i> Nutricionistas
        </a>
        <a class="nav-link @if(request()->is('tiendas*')) active @endif" href="{{ route('tiendas.index') }}">
            <i class="bi bi-shop me-1"></i> Tiendas
        </a>

        <span class="nav-section">Pacientes</span>
        <a class="nav-link @if(request()->is('pacientes*')) active @endif" href="{{ route('pacientes.index') }}">
            <i class="bi bi-people me-1"></i> Pacientes
        </a>
        <a class="nav-link @if(request()->is('mediciones*')) active @endif" href="{{ route('mediciones.index') }}">
            <i class="bi bi-activity me-1"></i> Mediciones
        </a>
        <a class="nav-link @if(request()->is('citas*')) active @endif" href="{{ route('citas.index') }}">
            <i class="bi bi-calendar-check me-1"></i> Citas
        </a>

        <span class="nav-section">Nutrición</span>
        <a class="nav-link @if(request()->is('recetas*')) active @endif" href="{{ route('recetas.index') }}">
            <i class="bi bi-journal-richtext me-1"></i> Recetas
        </a>
        <a class="nav-link @if(request()->is('ingredientes*')) active @endif" href="{{ route('ingredientes.index') }}">
            <i class="bi bi-basket me-1"></i> Ingredientes
        </a>
        <a class="nav-link @if(request()->is('oferta-ingredientes*')) active @endif" href="{{ route('oferta-ingredientes.index') }}">
            <i class="bi bi-tag me-1"></i> Ofertas
        </a>
        <a class="nav-link @if(request()->is('plan-semanales*')) active @endif" href="{{ route('plan-semanales.index') }}">
            <i class="bi bi-calendar-week me-1"></i> Planes Semanales
        </a>
        <a class="nav-link @if(request()->is('item-plans*')) active @endif" href="{{ route('item-plans.index') }}">
            <i class="bi bi-list-check me-1"></i> Items de Plan
        </a>

        <span class="nav-section">Comunicación</span>
        <a class="nav-link @if(request()->is('conversaciones*')) active @endif" href="{{ route('conversaciones.index') }}">
            <i class="bi bi-chat-dots me-1"></i> Conversaciones
        </a>
        <a class="nav-link @if(request()->is('mensajes*')) active @endif" href="{{ route('mensajes.index') }}">
            <i class="bi bi-envelope me-1"></i> Mensajes
        </a>

        <span class="nav-section">Facturación</span>
        <a class="nav-link @if(request()->is('facturas*')) active @endif" href="{{ route('facturas.index') }}">
            <i class="bi bi-receipt me-1"></i> Facturas
        </a>
        <a class="nav-link @if(request()->is('pagos*')) active @endif" href="{{ route('pagos.index') }}">
            <i class="bi bi-credit-card me-1"></i> Pagos
        </a>
    </nav>

    {{-- Main content --}}
    <main class="flex-grow-1 content-area">
        @if(session('exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('contenido')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
