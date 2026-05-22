<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php if (! empty(trim($__env->yieldContent('titulo')))): ?><?php echo $__env->yieldContent('titulo'); ?>@elsehasSection('title')<?php echo $__env->yieldContent('title'); ?><?php else: ?> Panel <?php endif; ?> — NutriPlan</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><text y='14' font-size='14'>🌸</text></svg>">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<?php if(Auth::user()->esNutricionista()): ?>
<style>
    :root{--verde:#2e7d52;--verde-light:#e8f5e9;}
    body{background:#f0f7f2;font-family:'Segoe UI',system-ui,sans-serif;}
    .topnav{background:#fff;border-bottom:1px solid #c8e6c9;position:sticky;top:0;z-index:100;box-shadow:0 1px 8px rgba(46,125,82,.08);}
    .topnav-inner{max-width:1350px;margin:0 auto;padding:0 1.2rem;height:56px;display:flex;align-items:center;gap:.6rem;}
    .brand{font-weight:800;font-size:1rem;color:var(--verde);text-decoration:none;display:flex;align-items:center;gap:.3rem;flex-shrink:0;}
    .nav-links{display:flex;align-items:center;gap:.05rem;flex:1;overflow-x:auto;padding:0 .2rem;}
    .nav-links::-webkit-scrollbar{display:none;}
    .nav-links .nav-item{text-decoration:none;display:flex;align-items:center;gap:.28rem;color:#5a7a6a;font-size:.82rem;font-weight:500;padding:.34rem .65rem;border-radius:7px;white-space:nowrap;transition:all .15s;}
    .nav-links .nav-item:hover{background:var(--verde-light);color:var(--verde);}
    .nav-links .nav-item.active{background:var(--verde-light);color:#1a5c38;font-weight:600;}
    .nav-links .nav-sep{width:1px;height:18px;background:#d4edda;margin:0 .15rem;flex-shrink:0;}
    .nav-user{display:flex;align-items:center;gap:.45rem;flex-shrink:0;}
    .avatar{width:32px;height:32px;border-radius:50%;background:var(--verde);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;}
    .avatar img{width:100%;height:100%;object-fit:cover;}
    .page-wrap{max-width:1200px;margin:0 auto;padding:1.8rem 1.5rem 4rem;}
    .card{border:none;border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,.07);}
    @media(max-width:700px){.nav-links .nav-item span{display:none;}.page-wrap{padding:1rem .8rem 3rem;}}
</style>
<?php else: ?>
<style>
    :root{--sidebar-w:240px;}
    body{background:#f1f3f5;font-family:'Segoe UI',system-ui,sans-serif;}
    .sidebar{width:var(--sidebar-w);min-height:100vh;background:#1a1f2e;position:fixed;top:0;left:0;z-index:1040;display:flex;flex-direction:column;}
    .sidebar-brand{padding:1.1rem 1.4rem;border-bottom:1px solid #2d3446;color:#a0aec0;font-weight:700;font-size:1rem;}
    .sidebar-brand i{color:#48bb78;}
    .sidebar-section{padding:.28rem 1rem .08rem;font-size:.66rem;text-transform:uppercase;letter-spacing:.09em;color:#48bb78;margin-top:.5rem;}
    .sidebar-nav{flex:1;padding:.4rem 0;overflow-y:auto;}
    .sidebar-nav .nav-link{color:#a0aec0;padding:.48rem 1.4rem;display:flex;align-items:center;gap:.5rem;font-size:.84rem;transition:background .15s;}
    .sidebar-nav .nav-link:hover,.sidebar-nav .nav-link.active{background:rgba(255,255,255,.07);color:#fff;}
    .sidebar-footer{padding:.85rem 1.4rem;border-top:1px solid #2d3446;}
    .main-content{margin-left:var(--sidebar-w);min-height:100vh;}
    .topbar{background:#fff;border-bottom:1px solid #e2e8f0;padding:.7rem 1.5rem;position:sticky;top:0;z-index:100;}
    .page-content{padding:1.8rem 2rem;}
    .card{border:none;border-radius:12px;box-shadow:0 1px 6px rgba(0,0,0,.07);}
    @media(max-width:768px){.sidebar{transform:translateX(-100%);transition:transform .25s;}.sidebar.show{transform:translateX(0);}.main-content{margin-left:0;}}
</style>
<?php endif; ?>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

<?php if(Auth::user()->esNutricionista()): ?>

<nav class="topnav">
    <div class="topnav-inner">
        <a href="<?php echo e(route('dashboard')); ?>" class="brand"><i class="bi bi-flower1"></i> NutriPlan</a>
        <div class="nav-links">
            <a href="<?php echo e(route('dashboard')); ?>"             class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active':''); ?>"><i class="bi bi-speedometer2"></i><span>Inicio</span></a>
            <div class="nav-sep"></div>
            <a href="<?php echo e(route('pacientes.index')); ?>"       class="nav-item <?php echo e(request()->routeIs('pacientes.*') ? 'active':''); ?>"><i class="bi bi-people"></i><span>Pacientes</span></a>
            <a href="<?php echo e(route('citas.index')); ?>"            class="nav-item <?php echo e(request()->routeIs('citas.*') ? 'active':''); ?>"><i class="bi bi-calendar-check"></i><span>Citas</span></a>
            <a href="<?php echo e(route('mediciones.index')); ?>"       class="nav-item <?php echo e(request()->routeIs('mediciones.*') ? 'active':''); ?>"><i class="bi bi-activity"></i><span>Mediciones</span></a>
            <div class="nav-sep"></div>
            <a href="<?php echo e(route('plan-semanales.index')); ?>"   class="nav-item <?php echo e(request()->routeIs('plan-semanales.*') ? 'active':''); ?>"><i class="bi bi-journal-richtext"></i><span>Planes</span></a>
            <a href="<?php echo e(route('recetas.index')); ?>"          class="nav-item <?php echo e(request()->routeIs('recetas.*') ? 'active':''); ?>"><i class="bi bi-book"></i><span>Recetas</span></a>
            <a href="<?php echo e(route('ingredientes.index')); ?>"     class="nav-item <?php echo e(request()->routeIs('ingredientes.*') ? 'active':''); ?>"><i class="bi bi-egg-fried"></i><span>Ingredientes</span></a>
            <div class="nav-sep"></div>
            <a href="<?php echo e(route('mensajes.chat')); ?>"   class="nav-item <?php echo e(request()->routeIs('mensajes.chat') || request()->routeIs('conversaciones.*') ? 'active':''); ?>"><i class="bi bi-chat-dots"></i><span>Mensajes</span></a>
            <div class="nav-sep"></div>
            <a href="<?php echo e(route('facturas.index')); ?>"         class="nav-item <?php echo e(request()->routeIs('facturas.*') ? 'active':''); ?>"><i class="bi bi-receipt"></i><span>Facturas</span></a>
            <a href="<?php echo e(route('pagos.index')); ?>"             class="nav-item <?php echo e(request()->routeIs('pagos.*') ? 'active':''); ?>"><i class="bi bi-credit-card"></i><span>Pagos</span></a>
            <div class="nav-sep"></div>
            <a href="<?php echo e(route('nutricionista.mi-perfil')); ?>" class="nav-item <?php echo e(request()->routeIs('nutricionista.mi-perfil') ? 'active':''); ?>"><i class="bi bi-person-circle"></i><span>Mi Perfil</span></a>
        </div>
        <div class="nav-user">
            <?php $n = Auth::user()->nutricionista; ?>
            <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['foto' => $n?->foto,'nombre' => Auth::user()->name,'size' => 32]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['foto' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($n?->foto),'nombre' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Auth::user()->name),'size' => 32]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $attributes = $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $component = $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
            <div class="d-none d-lg-block">
                <div style="font-size:.79rem;font-weight:600;color:#1a3d2b;line-height:1.2"><?php echo e(Auth::user()->name); ?></div>
                <div style="font-size:.69rem;color:#4caf50">Nutricionista</div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="mb-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-outline-success" style="font-size:.75rem;padding:.25rem .6rem" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</nav>
<div class="page-wrap">
    <?php if(session('exito')): ?><div class="alert alert-success alert-dismissible fade show rounded-3 mb-3"><i class="bi bi-check-circle-fill me-1"></i><?php echo e(session('exito')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <?php if(session('error')): ?><div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3"><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <?php echo $__env->yieldContent('contenido'); ?>
</div>

<?php else: ?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand"><i class="bi bi-flower1"></i> NutriPlan <span class="badge bg-danger ms-1" style="font-size:.58rem">Admin</span></div>
    <nav class="sidebar-nav">
        <a href="<?php echo e(route('admin.index')); ?>"            class="nav-link <?php echo e(request()->routeIs('admin.*') ? 'active':''); ?>"><i class="bi bi-shield-check"></i> Panel Admin</a>
        <div class="sidebar-section">Clínica</div>
        <a href="<?php echo e(route('pacientes.index')); ?>"        class="nav-link <?php echo e(request()->routeIs('pacientes.*') ? 'active':''); ?>"><i class="bi bi-people"></i> Pacientes</a>
        <a href="<?php echo e(route('citas.index')); ?>"             class="nav-link <?php echo e(request()->routeIs('citas.*') ? 'active':''); ?>"><i class="bi bi-calendar-event"></i> Citas</a>
        <a href="<?php echo e(route('plan-semanales.index')); ?>"    class="nav-link <?php echo e(request()->routeIs('plan-semanales.*') ? 'active':''); ?>"><i class="bi bi-journal-richtext"></i> Planes semanales</a>
        <a href="<?php echo e(route('mediciones.index')); ?>"        class="nav-link <?php echo e(request()->routeIs('mediciones.*') ? 'active':''); ?>"><i class="bi bi-activity"></i> Mediciones</a>
        <div class="sidebar-section">Nutrición</div>
        <a href="<?php echo e(route('recetas.index')); ?>"           class="nav-link <?php echo e(request()->routeIs('recetas.*') ? 'active':''); ?>"><i class="bi bi-book"></i> Recetas</a>
        <a href="<?php echo e(route('ingredientes.index')); ?>"      class="nav-link <?php echo e(request()->routeIs('ingredientes.*') ? 'active':''); ?>"><i class="bi bi-egg-fried"></i> Ingredientes</a>
        <div class="sidebar-section">Comunicación</div>
        <a href="<?php echo e(route('conversaciones.index')); ?>"    class="nav-link <?php echo e(request()->routeIs('conversaciones.*') || request()->routeIs('mensajes.*') ? 'active':''); ?>"><i class="bi bi-chat-dots"></i> Conversaciones</a>
        <div class="sidebar-section">Facturación</div>
        <a href="<?php echo e(route('facturas.index')); ?>"          class="nav-link <?php echo e(request()->routeIs('facturas.*') ? 'active':''); ?>"><i class="bi bi-receipt"></i> Facturas</a>
        <a href="<?php echo e(route('pagos.index')); ?>"              class="nav-link <?php echo e(request()->routeIs('pagos.*') ? 'active':''); ?>"><i class="bi bi-credit-card"></i> Pagos</a>
        <div class="sidebar-section">Administración</div>
        <a href="<?php echo e(route('nutricionistas.index')); ?>"    class="nav-link <?php echo e(request()->routeIs('nutricionistas.*') ? 'active':''); ?>"><i class="bi bi-person-badge"></i> Nutricionistas</a>
        <a href="<?php echo e(route('tiendas.index')); ?>"            class="nav-link <?php echo e(request()->routeIs('tiendas.*') ? 'active':''); ?>"><i class="bi bi-shop"></i> Tiendas</a>
    </nav>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:28px;height:28px;font-size:.7rem;font-weight:700">
                <?php echo e(strtoupper(substr(Auth::user()->name,0,2))); ?>

            </div>
            <div class="overflow-hidden">
                <div class="text-white small fw-semibold text-truncate" style="max-width:140px"><?php echo e(Auth::user()->name); ?></div>
                <div style="font-size:.68rem;color:#6b9f6b">Admin</div>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-sm btn-outline-light w-100" style="font-size:.78rem">
                <i class="bi bi-box-arrow-left"></i> Cerrar sesión
            </button>
        </form>
    </div>
</aside>
<div class="main-content">
    <header class="topbar d-flex align-items-center justify-content-between">
        <button class="btn btn-sm d-md-none border-0" onclick="document.getElementById('sidebar').classList.toggle('show')"><i class="bi bi-list fs-5"></i></button>
        <span class="text-muted small fw-semibold d-none d-md-inline"><?php echo $__env->yieldContent('breadcrumb',''); ?></span>
        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 small"><i class="bi bi-shield-check me-1"></i>Admin</span>
    </header>
    <main class="page-content">
        <?php if(session('exito')): ?><div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-1"></i><?php echo e(session('exito')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php if(session('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <?php echo $__env->yieldContent('contenido'); ?>
    </main>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/layouts/app.blade.php ENDPATH**/ ?>