<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mi Panel') — NutriPlan</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><text y='14' font-size='14'>🌸</text></svg>">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --verde: #2e7d52; --verde-light: #e8f5e9; }
        body { background: #f0f7f2; font-family: 'Segoe UI', system-ui, sans-serif; }

        /* ── TOP NAV ── */
        .topnav {
            background: #fff;
            border-bottom: 1px solid #c8e6c9;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 8px rgba(46,125,82,.08);
        }
        .topnav-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 1.5rem;
            height: 58px; display: flex; align-items: center; gap: 1rem;
        }
        .brand { font-weight: 800; font-size: 1.05rem; color: var(--verde); text-decoration: none; display: flex; align-items: center; gap: .35rem; flex-shrink: 0; }
        .brand i { font-size: 1.2rem; }

        .nav-links { display: flex; align-items: center; gap: .15rem; flex: 1; flex-wrap: nowrap; overflow-x: auto; padding: 0 .5rem; }
        .nav-links::-webkit-scrollbar { display: none; }
        .nav-links .nav-item { text-decoration: none; display: flex; align-items: center; gap: .3rem;
            color: #5a7a6a; font-size: .84rem; font-weight: 500; padding: .38rem .75rem;
            border-radius: 8px; white-space: nowrap; transition: all .15s; }
        .nav-links .nav-item:hover { background: var(--verde-light); color: var(--verde); }
        .nav-links .nav-item.active { background: var(--verde-light); color: #1a5c38; font-weight: 600; }
        .nav-links .nav-item i { font-size: .95rem; }

        .nav-user { display: flex; align-items: center; gap: .6rem; flex-shrink: 0; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--verde);
            color: #fff; font-size: .75rem; font-weight: 700; display: flex; align-items: center; justify-content: center;
            overflow: hidden; flex-shrink: 0; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* ── CONTENT ── */
        .page-wrap { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

        /* ── CARDS ── */
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 6px rgba(0,0,0,.07); }
        .card-header { border-radius: 12px 12px 0 0 !important; }

        /* ── MOBILE ── */
        @media (max-width: 600px) {
            .nav-links .nav-item span { display: none; }
            .page-wrap { padding: 1rem .8rem 3rem; }
        }
    </style>
    @yield('styles')
</head>
<body>

<nav class="topnav">
    <div class="topnav-inner">
        <a href="{{ route('paciente.mi-dia') }}" class="brand">
            <i class="bi bi-flower1"></i> NutriPlan
        </a>

        <div class="nav-links">
            <a href="{{ route('paciente.mi-dia') }}"        class="nav-item {{ request()->routeIs('paciente.mi-dia') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i><span>Mi Día</span>
            </a>
            <a href="{{ route('paciente.mi-plan') }}"       class="nav-item {{ request()->routeIs('paciente.mi-plan') ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i><span>Mi Plan</span>
            </a>
            <a href="{{ route('paciente.mi-progreso') }}"   class="nav-item {{ request()->routeIs('paciente.mi-progreso') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i><span>Progreso</span>
            </a>
            <a href="{{ route('paciente.mis-consultas') }}" class="nav-item {{ request()->routeIs('paciente.mis-consultas') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i><span>Consultas</span>
            </a>
            <a href="{{ route('paciente.mis-mensajes') }}"  class="nav-item {{ request()->routeIs('paciente.mis-mensajes') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i><span>Mensajes</span>
            </a>
            <a href="{{ route('paciente.mis-facturas') }}"  class="nav-item {{ request()->routeIs('paciente.mis-facturas') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i><span>Facturas</span>
            </a>
            <a href="{{ route('paciente.mi-perfil') }}"     class="nav-item {{ request()->routeIs('paciente.mi-perfil') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i><span>Mi Perfil</span>
            </a>
        </div>

        <div class="nav-user">
            @php $pacienteNav = Auth::user()->paciente; @endphp
            <x-avatar :foto="$pacienteNav?->foto" :nombre="Auth::user()->name" :size="34" />
            <div class="d-none d-md-block">
                <div style="font-size:.8rem;font-weight:600;color:#1a3d2b;line-height:1.2">{{ Auth::user()->name }}</div>
                <div style="font-size:.7rem;color:#4caf50">Paciente</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button class="btn btn-sm btn-outline-success" style="font-size:.75rem;padding:.25rem .6rem" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="page-wrap">
    @if (session('exito'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
            <i class="bi bi-check-circle-fill me-1"></i>{{ session('exito') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3">
            {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('contenido')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
