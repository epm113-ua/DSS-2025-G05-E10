<?php $__env->startSection('titulo', 'Facturas'); ?>
<?php $__env->startSection('breadcrumb', 'Facturas'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-success"></i>Facturas</h4>
    <a href="<?php echo e(route('facturas.create')); ?>" class="btn btn-success btn-sm"><i class="bi bi-plus-lg me-1"></i>Nueva factura</a>
</div>

<form method="GET" action="<?php echo e(route('facturas.index')); ?>" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Nº factura..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <div class="col-md-3">
                <select name="paciente_id" class="form-select form-select-sm">
                    <option value="">Todos los pacientes</option>
                    <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php if(request('paciente_id') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="estado" class="form-select form-select-sm">
                    <option value="">Todos los estados</option>
                    <option value="pagada"   <?php if(request('estado')=='pagada'): echo 'selected'; endif; ?>>Pagada</option>
                    <option value="pendiente"<?php if(request('estado')=='pendiente'): echo 'selected'; endif; ?>>Pendiente</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success btn-sm w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="<?php echo e(route('facturas.index')); ?>" class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
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
                    <th>Nº Factura</th>
                    <th>Paciente</th>
                    <th>Importe</th>
                    <th>Estado</th>
                    <th>Pagado el</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $facturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-semibold"><?php echo e($f->numero_factura); ?></td>
                    <td><?php echo e($f->paciente->nombre_completo ?? '—'); ?></td>
                    <td class="fw-semibold"><?php echo e(number_format($f->importe,2)); ?> €</td>
                    <td>
                        <?php if($f->pagado_en): ?>
                            <span class="badge bg-success">Pagada</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($f->pagado_en ? $f->pagado_en->format('d/m/Y H:i') : '—'); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('facturas.edit',$f)); ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('facturas.destroy',$f)); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta factura?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay facturas registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($facturas->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/facturas/index.blade.php ENDPATH**/ ?>