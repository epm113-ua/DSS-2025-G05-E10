<?php $__env->startSection('title','Mi Día'); ?>
<?php $__env->startSection('breadcrumb','Mi Día'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">¡Buenos días, <?php echo e(Auth::user()->name); ?>!</h4>
        <p class="text-muted small mb-0"><?php echo e(now()->isoFormat('dddd, D [de] MMMM')); ?></p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <?php if($paciente->nutricionista?->foto): ?>
            <img src="<?php echo e(asset('storage/'.$paciente->nutricionista->foto)); ?>" class="rounded-circle" style="width:36px;height:36px;object-fit:cover">
        <?php else: ?>
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:.75rem;font-weight:700">
                <?php echo e(strtoupper(substr($paciente->nutricionista?->nombre_completo ?? 'N',0,2))); ?>

            </div>
        <?php endif; ?>
        <span class="text-muted small d-none d-md-inline"><?php echo e($paciente->nutricionista?->nombre_completo); ?></span>
    </div>
</div>

<div class="row g-4">
    
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-sun me-1"></i>Comidas de hoy</div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $itemsHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 flex-shrink-0">
                            <i class="bi bi-egg-fried text-success"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small"><?php echo e($item->tipo_comida); ?></div>
                            <div class="text-muted small"><?php echo e($item->receta?->nombre ?? '—'); ?></div>
                            <?php if($item->receta): ?>
                                <div class="text-muted" style="font-size:.72rem"><?php echo e($item->receta->calorias_kcal); ?> kcal</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted text-center py-3">No hay comidas planificadas para hoy.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-lg-5 d-flex flex-column gap-3">
        
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-calendar-check me-1"></i>Próxima cita</div>
            <div class="card-body text-center">
                <?php if($proximaCita): ?>
                    <div class="fw-bold fs-5"><?php echo e($proximaCita->inicio->format('d/m/Y')); ?></div>
                    <div class="text-muted small"><?php echo e($proximaCita->inicio->format('H:i')); ?></div>
                    <div class="text-muted small mt-1"><?php echo e($proximaCita->motivo); ?></div>
                <?php else: ?>
                    <p class="text-muted small mb-0">No hay citas próximas.</p>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($ultimaMedicion): ?>
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-activity me-1"></i>Última medición</div>
            <div class="card-body">
                <div class="row text-center g-2">
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-success"><?php echo e($ultimaMedicion->peso_kg); ?> kg</div>
                        <div class="text-muted" style="font-size:.72rem">Peso</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5"><?php echo e($ultimaMedicion->imc); ?></div>
                        <div class="text-muted" style="font-size:.72rem">IMC</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5"><?php echo e($ultimaMedicion->porcentaje_grasa); ?>%</div>
                        <div class="text-muted" style="font-size:.72rem">Grasa</div>
                    </div>
                </div>
                <div class="text-muted text-center small mt-2"><?php echo e($ultimaMedicion->fecha_medicion->format('d/m/Y')); ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mi-dia.blade.php ENDPATH**/ ?>