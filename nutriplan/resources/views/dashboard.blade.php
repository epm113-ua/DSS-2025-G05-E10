@php
    $esAdmin       = \App\Models\User::modoAdmin();
    $usuarioActual = \App\Models\User::currentUser();
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan – Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f7f4; font-family: 'Segoe UI', sans-serif; }
        .topbar { background:#fff; border-bottom:1px solid #e8ede8; padding:.75rem 2rem;
                  display:flex; justify-content:space-between; align-items:center; }
        .brand  { display:flex; align-items:center; gap:.5rem; font-weight:700; font-size:1.1rem; color:#2c7a4b; }
        .brand i { font-size:1.4rem; }
        .user-pill { display:flex; align-items:center; gap:.5rem;
                     background:#f4f7f4; border:1px solid #dde8dd; border-radius:50px;
                     padding:.3rem .8rem .3rem .3rem; }
        .user-avatar { width:32px; height:32px; border-radius:50%; background:#2c7a4b;
                       color:#fff; display:flex; align-items:center; justify-content:center;
                       font-weight:700; font-size:.85rem; }
        .hero { text-align:center; padding:3rem 1rem 2rem; }
        .hero h1 { font-size:2rem; font-weight:700; color:#1a1a1a; margin-bottom:.5rem; }
        .hero p  { color:#6c757d; font-size:1rem; }
        .feature-card { background:#fff; border:1px solid #e0ebe0; border-radius:16px;
                        padding:2rem 1.5rem; text-align:center; transition:.2s;
                        display:flex; flex-direction:column; align-items:center; gap:.75rem; }
        .feature-card:hover { box-shadow:0 8px 24px rgba(44,122,75,.12); transform:translateY(-3px); }
        .icon-wrap { width:64px; height:64px; border-radius:16px; background:#f0f8f2;
                     display:flex; align-items:center; justify-content:center; }
        .icon-wrap i { font-size:1.8rem; color:#2c7a4b; }
        .feature-card h5 { font-weight:700; font-size:1.05rem; margin:0; color:#1a1a1a; }
        .feature-card p  { color:#6c757d; font-size:.88rem; margin:0; min-height:48px; }
        .btn-card { border:1px solid #2c7a4b; color:#2c7a4b; background:#fff; border-radius:8px;
                    font-size:.88rem; padding:.4rem 1.2rem; margin-top:.5rem; text-decoration:none; }
        .btn-card:hover { background:#2c7a4b; color:#fff; }
        .btn-role { border-radius:8px; font-size:.85rem; font-weight:600;
                    padding:.45rem 1.1rem; text-decoration:none; border:none; cursor:pointer; }
        footer { border-top:1px solid #e0ebe0; padding:1.2rem 2rem; margin-top:3rem;
                 display:flex; justify-content:space-between; align-items:center;
                 font-size:.83rem; color:#6c757d; background:#fff; }
        footer a { color:#6c757d; text-decoration:none; }
        footer a:hover { color:#2c7a4b; }
    </style>
</head>
<body>

{{-- Topbar --}}
<header class="topbar">
    <div class="brand">
        <i class="bi bi-heart-pulse-fill"></i> NutriPlan
    </div>
    <div class="d-flex align-items-center gap-3">
        {{-- Botones según modo --}}
        <span class="badge bg-warning text-dark px-3 py-2" style="font-size:.82rem;">
            <i class="bi bi-shield-fill me-1"></i>Admin
        </span>
        <a href="{{ route('admin.index') }}" class="btn-role text-white"
           style="background:linear-gradient(135deg,#ff6b35,#f7931e);">
            <i class="bi bi-shield-lock-fill me-1"></i>Panel Admin
        </a>
        <form action="{{ route('cambiar-modo') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn-role" style="border:1px solid #adb5bd; background:#fff; color:#495057;">
                <i class="bi bi-person me-1"></i>Cambiar a Usuario
            </button>
        </form>
        <div class="user-pill">
            <div class="user-avatar">{{ strtoupper(substr($usuarioActual->name, 0, 2)) }}</div>
            <span style="font-size:.88rem; font-weight:500;">{{ Str::words($usuarioActual->name, 1, '.') }}</span>
        </div>
    </div>
</header>

{{-- Hero --}}
<section class="hero">
    <h1>¡Bienvenido/a, {{ Str::words($usuarioActual->name, 1, '') }}!<br>Bienvenido a NutriPlan.</h1>
    <p>Tu dashboard de gestión nutricional simplificado.</p>
</section>

<div class="container" style="max-width:900px;">

    {{-- 4 tarjetas --}}
    <div class="row g-4 justify-content-center">
        <div class="col-sm-6 col-lg-3">
            <div class="feature-card h-100">
                <div class="icon-wrap"><i class="bi bi-people"></i></div>
                <h5>Pacientes</h5>
                <p>Gestión de pacientes y expedientes.</p>
                <a href="{{ route('pacientes.index') }}" class="btn-card">Ir a Pacientes</a>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="feature-card h-100">
                <div class="icon-wrap"><i class="bi bi-journal-richtext"></i></div>
                <h5>Dietas</h5>
                <p>Creación de planes nutricionales personalizados.</p>
                <a href="{{ route('plan-semanales.create') }}" class="btn-card">Crear Plan</a>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="feature-card h-100">
                <div class="icon-wrap"><i class="bi bi-calendar-check"></i></div>
                <h5>Citas</h5>
                <p>Agenda y próximas consultas.</p>
                <a href="{{ route('citas.index') }}" class="btn-card">Ver Calendario</a>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="feature-card h-100">
                <div class="icon-wrap"><i class="bi bi-bar-chart-line"></i></div>
                <h5>Reportes</h5>
                <p>Informes de progreso y estadísticas.</p>
                <a href="{{ route('admin.index') }}" class="btn-card">Ver Reportes</a>
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    @php
        $stats = [
            'nutricionistas'      => \App\Models\Nutricionista::count(),
            'pacientes'           => \App\Models\Paciente::count(),
            'facturas_pendientes' => \App\Models\Factura::whereNull('pagado_en')->count(),
        ];
    @endphp
    <div class="row g-3 mt-4">
        <div class="col-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-3 fw-bold text-success">{{ $stats['nutricionistas'] }}</div>
                <div class="text-muted small">Nutricionistas</div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-3 fw-bold text-primary">{{ $stats['pacientes'] }}</div>
                <div class="text-muted small">Pacientes</div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-3 fw-bold text-danger">{{ $stats['facturas_pendientes'] }}</div>
                <div class="text-muted small">Facturas pendientes</div>
            </div>
        </div>
    </div>

    {{-- Citas recientes --}}
    @php
        $citasRecientes = \App\Models\Cita::with(['paciente','nutricionista'])
            ->orderByDesc('inicio')->limit(5)->get();
    @endphp
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-calendar-check me-2 text-success"></i>Citas recientes
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 small">
                <thead class="table-light">
                    <tr><th>Fecha</th><th>Paciente</th><th>Nutricionista</th><th>Estado</th></tr>
                </thead>
                <tbody>
                @php $b=['pendiente'=>'warning','completada'=>'success','cancelada'=>'danger']; @endphp
                @forelse($citasRecientes as $c)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($c->inicio)->format('d/m/Y') }}</td>
                        <td>{{ $c->paciente->nombre_completo ?? '—' }}</td>
                        <td>{{ $c->nutricionista->nombre_completo ?? '—' }}</td>
                        <td><span class="badge bg-{{ $b[$c->estado] ?? 'secondary' }}">{{ ucfirst($c->estado) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Sin citas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0">
            <a href="{{ route('citas.index') }}" class="btn btn-sm btn-outline-success">Ver todas las citas</a>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="mt-4 mb-2">
        <h6 class="text-muted fw-semibold mb-3">
            <i class="bi bi-lightning-charge me-1 text-warning"></i>Accesos rápidos
        </h6>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('nutricionistas.create') }}" class="btn btn-outline-success btn-sm">
                <i class="bi bi-plus me-1"></i>Nuevo nutricionista
            </a>
            <a href="{{ route('pacientes.create') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-plus me-1"></i>Nuevo paciente
            </a>
            <a href="{{ route('citas.create') }}" class="btn btn-outline-warning btn-sm">
                <i class="bi bi-plus me-1"></i>Nueva cita
            </a>
            <a href="{{ route('recetas.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-plus me-1"></i>Nueva receta
            </a>
        </div>
    </div>

</div>

<footer>
    <div class="d-flex align-items-center gap-2" style="color:#2c7a4b; font-weight:600;">
        <i class="bi bi-heart-pulse-fill"></i> NutriPlan
        <span class="text-muted fw-normal ms-2">© {{ date('Y') }} NutriPlan. All rights reserved.</span>
    </div>
    <div class="d-flex gap-3">
        <a href="#">Ayuda</a>
        <a href="#">Términos</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
