<?php $__env->startSection('titulo','Gestión de usuarios'); ?>
<?php $__env->startSection('breadcrumb','Admin › Usuarios'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-success"></i>Gestión de Usuarios</h4>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.index')); ?>" class="btn btn-outline-secondary btn-sm">← Panel</a>
        <a href="<?php echo e(route('admin.usuarios.crear')); ?>" class="btn btn-success btn-sm"><i class="bi bi-person-plus me-1"></i>Nuevo usuario</a>
    </div>
</div>

<form method="GET" action="<?php echo e(route('admin.usuarios')); ?>" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Nombre o email..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <div class="col-md-3">
                <select name="rol" class="form-select form-select-sm">
                    <option value="">Todos los roles</option>
                    <option value="admin"         <?php if(request('rol')=='admin'): echo 'selected'; endif; ?>>Admin</option>
                    <option value="nutricionista" <?php if(request('rol')=='nutricionista'): echo 'selected'; endif; ?>>Nutricionista</option>
                    <option value="paciente"      <?php if(request('rol')=='paciente'): echo 'selected'; endif; ?>>Paciente</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="<?php echo e(route('admin.usuarios')); ?>" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
            </div>
        </div>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-dark">
                <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Vinculado a</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted small"><?php echo e($u->id); ?></td>
                    <td class="fw-semibold"><?php echo e($u->name); ?></td>
                    <td class="small"><?php echo e($u->email); ?></td>
                    <td>
                        <?php $colores=['admin'=>'danger','nutricionista'=>'primary','paciente'=>'success']; ?>
                        <span class="badge bg-<?php echo e($colores[$u->rol] ?? 'secondary'); ?> text-capitalize"><?php echo e($u->rol); ?></span>
                    </td>
                    <td class="small text-muted">
                        <?php if($u->paciente): ?> Paciente: <?php echo e($u->paciente->nombre_completo); ?>

                        <?php elseif($u->nutricionista): ?> Nutricionista: <?php echo e($u->nutricionista->nombre_completo); ?>

                        <?php else: ?> —
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <?php if($u->id !== Auth::id()): ?>
                            <form method="POST" action="<?php echo e(route('admin.usuarios.toggle',$u)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="btn btn-sm btn-outline-warning" title="<?php echo e($u->esAdmin()?'Quitar admin':'Hacer admin'); ?>">
                                    <i class="bi bi-shield<?php echo e($u->esAdmin()?'-x':'-check'); ?>"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('admin.usuarios.eliminar',$u)); ?>" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar a <?php echo e($u->name); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted small">(tú)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay usuarios.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($usuarios->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/admin/usuarios.blade.php ENDPATH**/ ?>