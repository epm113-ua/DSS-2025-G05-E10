<?php $__env->startSection('titulo','Pagos'); ?>
<?php $__env->startSection('breadcrumb','Pagos'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-credit-card me-2 text-success"></i>Pagos</h4>
    <a href="<?php echo e(route('pagos.create')); ?>" class="btn btn-success btn-sm"><i class="bi bi-plus-lg me-1"></i>Nuevo pago</a>
</div>

<form method="GET" action="<?php echo e(route('pagos.index')); ?>" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Titular o nº factura..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <div class="col-md-3">
                <select name="forma_pago" class="form-select form-select-sm">
                    <option value="">Todas las formas</option>
                    <?php $__currentLoopData = $formas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($f); ?>" <?php if(request('forma_pago')==$f): echo 'selected'; endif; ?>><?php echo e($f); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="<?php echo e(route('pagos.index')); ?>" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
            </div>
        </div>
        <input type="hidden" name="orden" value="<?php echo e($orden); ?>">
        <input type="hidden" name="dir"   value="<?php echo e($dir); ?>">
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr>
                    <th>Factura</th>
                    <th>Titular</th>
                    <th>Importe</th>
                    <th>Forma de pago</th>
                    <th>Fecha</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-semibold"><?php echo e($p->factura->numero_factura ?? '—'); ?></td>
                    <td><?php echo e($p->nombre_titular); ?></td>
                    <td class="fw-semibold text-success"><?php echo e(number_format($p->importe,2)); ?> €</td>
                    <td><span class="badge bg-info text-dark"><?php echo e($p->forma_pago); ?></span></td>
                    <td><?php echo e($p->fecha_pago->format('d/m/Y H:i')); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('pagos.edit',$p)); ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('pagos.destroy',$p)); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este pago?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay pagos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($pagos->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/pagos/index.blade.php ENDPATH**/ ?>