<?php $__env->startSection('title','Mis Facturas'); ?>
<?php $__env->startSection('breadcrumb','Mis Facturas'); ?>
<?php $__env->startSection('contenido'); ?>
<h4 class="fw-bold mb-4">Mis Facturas</h4>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr><th>Nº Factura</th><th>Fecha</th><th>Importe</th><th>Estado</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $facturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $factura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-semibold"><?php echo e($factura->numero_factura ?? '#'.$factura->id); ?></td>
                    <td><?php echo e($factura->created_at->format('d/m/Y')); ?></td>
                    <td class="fw-semibold"><?php echo e(number_format($factura->importe ?? 0,2)); ?> €</td>
                    <td>
                        <?php if($factura->pagado_en): ?>
                            <span class="badge bg-success">Pagada</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center text-muted py-4">No tienes facturas registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo e($facturas->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mis-facturas.blade.php ENDPATH**/ ?>