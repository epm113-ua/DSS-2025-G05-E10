<?php $__env->startSection('titulo', 'Mi plan semanal'); ?>

<?php $__env->startSection('contenido'); ?>
<h1 class="page-title">Mi plan semanal</h1>
<p class="text-muted mb-4">Plan completo de la semana asignado por tu nutricionista.</p>

<?php if(!$plan): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
            <h5>Aún no tienes plan asignado</h5>
            <p class="text-muted">Tu nutricionista te asignará un plan semanal tras tu próxima consulta.</p>
        </div>
    </div>
<?php else: ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <div>
                    <small class="text-muted">Semana de</small>
                    <h5 class="mb-0"><?php echo e(\Carbon\Carbon::parse($plan->semana_inicio)->locale('es')->isoFormat('D [de] MMMM Y')); ?></h5>
                </div>
                <div class="text-end">
                    <small class="text-muted">Asignado por</small>
                    <h6 class="mb-0"><?php echo e($plan->cita->nutricionista->nombre_completo ?? '—'); ?></h6>
                </div>
            </div>
            <?php if($plan->notas): ?>
                <hr>
                <small class="text-muted"><?php echo e($plan->notas); ?></small>
            <?php endif; ?>
        </div>
    </div>

    <?php
        $diasSemana = [1=>'Lunes', 2=>'Martes', 3=>'Miércoles', 4=>'Jueves', 5=>'Viernes', 6=>'Sábado', 7=>'Domingo'];
    ?>

    <div class="row g-3">
        <?php $__currentLoopData = $diasSemana; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100">
                    <div class="card-header bg-success bg-opacity-10 border-bottom">
                        <strong class="text-success-dark"><?php echo e($nombre); ?></strong>
                    </div>
                    <div class="card-body p-3">
                        <?php $itemsDia = $itemsPorDia->get($num, collect())->sortBy('tipo_comida'); ?>
                        <?php $__empty_1 = true; $__currentLoopData = $itemsDia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="border-start border-3 border-success ps-2 mb-3">
                                <span class="badge bg-secondary-subtle text-secondary small"><?php echo e(ucfirst($item->tipo_comida)); ?></span>
                                <div class="fw-bold small mt-1"><?php echo e($item->receta->nombre ?? '—'); ?></div>
                                <?php if($item->notas): ?>
                                    <div class="text-muted" style="font-size: .75rem"><?php echo e($item->notas); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <small class="text-muted">Sin comidas planificadas</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mi-plan.blade.php ENDPATH**/ ?>