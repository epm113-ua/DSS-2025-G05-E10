<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'NutriPlan'); ?> — Nutrición personalizada</title>
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
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(route('inicio')); ?>">
            <i class="bi bi-flower1 text-success"></i> <span>NutriPlan</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPublico">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navPublico">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('inicio') ? 'active fw-semibold' : ''); ?>" href="<?php echo e(route('inicio')); ?>">Inicio</a></li>
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('sobre') ? 'active fw-semibold' : ''); ?>" href="<?php echo e(route('sobre')); ?>">Sobre nosotros</a></li>
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('contacto') ? 'active fw-semibold' : ''); ?>" href="<?php echo e(route('contacto')); ?>">Contacto</a></li>
            </ul>
            <div class="d-flex gap-2">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(Auth::user()->rutaInicio()); ?>" class="btn btn-verde btn-sm rounded-pill px-3">Mi panel</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">Iniciar sesión</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-verde btn-sm rounded-pill px-3">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="py-4 mt-5">
    <div class="container text-center">
        <p class="mb-1"><strong class="text-white"><i class="bi bi-flower1"></i> NutriPlan</strong></p>
        <p class="small mb-0">&copy; <?php echo e(date('Y')); ?> NutriPlan. Nutrición personalizada.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/layouts/publico.blade.php ENDPATH**/ ?>