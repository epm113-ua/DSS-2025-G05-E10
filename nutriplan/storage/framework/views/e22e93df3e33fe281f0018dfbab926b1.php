<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb', 'Dashboard'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0">¡Bienvenido/a, <?php echo e(Auth::user()->name); ?>!</h4>
    <p class="text-muted small mb-0"><?php echo e(now()->isoFormat('dddd, D [de] MMMM [de] YYYY')); ?></p>
</div>

<?php if(Auth::user()->esAdmin()): ?>

<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['bi-people-fill',    'text-primary', 'bg-primary', 'Nutricionistas',       $stats['nutricionistas']],
        ['bi-person-check',   'text-success', 'bg-success', 'Pacientes',             $stats['pacientes']],
        ['bi-calendar-event', 'text-warning', 'bg-warning', 'Citas hoy',             $stats['citas_hoy']],
        ['bi-receipt',        'text-danger',  'bg-danger',  'Facturas pendientes',   $stats['facturas_pendientes']],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon, $textColor, $bgColor, $label, $valor]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle <?php echo e($bgColor); ?> bg-opacity-10 p-3">
                    <i class="bi <?php echo e($icon); ?> <?php echo e($textColor); ?> fs-5"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold"><?php echo e($valor); ?></div>
                    <div class="text-muted small"><?php echo e($label); ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-people fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Gestión de usuarios</h6>
            <p class="text-muted small">Administra roles y accesos del sistema.</p>
            <a href="<?php echo e(route('admin.usuarios')); ?>" class="btn btn-outline-success btn-sm mt-auto">Ver usuarios</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-person-badge fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Nutricionistas</h6>
            <p class="text-muted small">Gestiona el equipo de profesionales.</p>
            <a href="<?php echo e(route('nutricionistas.index')); ?>" class="btn btn-outline-success btn-sm mt-auto">Ver nutricionistas</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-receipt fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Facturación</h6>
            <p class="text-muted small">Revisa el estado de facturas y pagos.</p>
            <a href="<?php echo e(route('facturas.index')); ?>" class="btn btn-outline-success btn-sm mt-auto">Ver facturas</a>
        </div>
    </div>
</div>

<?php else: ?>

<div class="row g-3 mb-4">
    <?php $__currentLoopData = [
        ['bi-people',         'text-primary', 'bg-primary', 'Mis pacientes',        $stats['mis_pacientes']],
        ['bi-calendar-check', 'text-success', 'bg-success', 'Citas hoy',            $stats['citas_hoy']],
        ['bi-clock-history',  'text-warning', 'bg-warning', 'Citas pendientes',     $stats['citas_pendientes']],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon, $textColor, $bgColor, $label, $valor]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle <?php echo e($bgColor); ?> bg-opacity-10 p-3">
                    <i class="bi <?php echo e($icon); ?> <?php echo e($textColor); ?> fs-5"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold"><?php echo e($valor); ?></div>
                    <div class="text-muted small"><?php echo e($label); ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-people fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Pacientes</h6>
            <a href="<?php echo e(route('pacientes.index')); ?>" class="btn btn-outline-success btn-sm mt-2">Gestionar</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-calendar-event fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Citas</h6>
            <a href="<?php echo e(route('citas.index')); ?>" class="btn btn-outline-success btn-sm mt-2">Ver agenda</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-journal-richtext fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Planes</h6>
            <a href="<?php echo e(route('plan-semanales.index')); ?>" class="btn btn-outline-success btn-sm mt-2">Ver planes</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center h-100">
            <i class="bi bi-chat-dots fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Mensajes</h6>
            <a href="<?php echo e(route('conversaciones.index')); ?>" class="btn btn-outline-success btn-sm mt-2">Ver chat</a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/dashboard.blade.php ENDPATH**/ ?>