<?php $__env->startSection('title','Mis Consultas'); ?>
<?php $__env->startSection('breadcrumb','Mis Consultas'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Mis Consultas</h4>
        <small class="text-muted">Con <?php echo e($paciente->nutricionista?->nombre_completo); ?></small>
    </div>
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalSolicitar">
        <i class="bi bi-plus-circle me-1"></i>Solicitar cita
    </button>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr><th>Fecha</th><th>Hora</th><th>Nutricionista</th><th>Motivo</th><th>Estado</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($cita->inicio->format('d/m/Y')); ?></td>
                    <td><?php echo e($cita->inicio->format('H:i')); ?></td>
                    <td><?php echo e($cita->nutricionista?->nombre_completo ?? '—'); ?></td>
                    <td class="text-muted small"><?php echo e($cita->motivo); ?></td>
                    <td>
                        <?php $badges=['pendiente'=>'warning','completada'=>'success','cancelada'=>'secondary']; ?>
                        <span class="badge bg-<?php echo e($badges[$cita->estado] ?? 'secondary'); ?> text-capitalize"><?php echo e($cita->estado); ?></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No tienes consultas registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo e($citas->links()); ?>


<div class="modal fade" id="modalSolicitar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Solicitar nueva cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('paciente.solicitar-cita')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Fecha y hora deseada</label>
                        <input type="datetime-local" name="inicio" class="form-control" required
                               min="<?php echo e(now()->addHour()->format('Y-m-d\TH:i')); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Motivo (opcional)</label>
                        <textarea name="motivo" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Solicitar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mis-consultas.blade.php ENDPATH**/ ?>