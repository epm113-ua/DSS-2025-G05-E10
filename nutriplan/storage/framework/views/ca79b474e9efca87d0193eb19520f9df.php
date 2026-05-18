<?php $__env->startSection('titulo', 'Mi progreso'); ?>

<?php $__env->startSection('contenido'); ?>
<h1 class="page-title">Mi progreso</h1>
<p class="text-muted mb-4">Evolución de tus mediciones a lo largo del tiempo.</p>

<?php if($mediciones->isEmpty()): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-graph-up fs-1 text-muted d-block mb-3"></i>
            <h5>Sin mediciones registradas</h5>
            <p class="text-muted">Tu nutricionista registrará tus mediciones tras cada consulta.</p>
        </div>
    </div>
<?php else: ?>
    <div class="row g-3 mb-4">
        <?php $ultima = $mediciones->last(); ?>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">Peso actual</small>
                <h3 class="text-success-dark mb-0"><?php echo e($ultima->peso_kg); ?> kg</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">IMC</small>
                <h3 class="text-info mb-0"><?php echo e($ultima->imc ? number_format($ultima->imc, 1) : '—'); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">Altura</small>
                <h3 class="mb-0"><?php echo e($ultima->altura_cm); ?> cm</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">Mediciones</small>
                <h3 class="mb-0"><?php echo e($mediciones->count()); ?></h3>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white"><h5 class="mb-0">Evolución del peso</h5></div>
        <div class="card-body">
            <canvas id="graficoPeso" height="80"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white"><h5 class="mb-0">Histórico de mediciones</h5></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Peso (kg)</th>
                            <th>Altura (cm)</th>
                            <th>IMC</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $mediciones->sortByDesc('fecha_medicion'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($m->fecha_medicion->format('d/m/Y')); ?></td>
                                <td><?php echo e($m->peso_kg); ?></td>
                                <td><?php echo e($m->altura_cm); ?></td>
                                <td><?php echo e($m->imc ? number_format($m->imc, 1) : '—'); ?></td>
                                <td class="text-muted small"><?php echo e($m->notas ?: '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php if($mediciones->isNotEmpty()): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('graficoPeso');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($mediciones->map(fn($m) => $m->fecha_medicion->format('d/m'))->values(), 15, 512) ?>,
            datasets: [{
                label: 'Peso (kg)',
                data: <?php echo json_encode($mediciones->pluck('peso_kg')->values(), 15, 512) ?>,
                borderColor: '#2c7a4b',
                backgroundColor: 'rgba(44, 122, 75, .15)',
                tension: .3,
                fill: true,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mi-progreso.blade.php ENDPATH**/ ?>