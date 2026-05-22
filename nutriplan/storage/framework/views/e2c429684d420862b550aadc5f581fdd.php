<?php $__env->startSection('titulo', 'Mediciones'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-activity me-2 text-success"></i>Mediciones</h2>
    <a href="<?php echo e(route('mediciones.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva medición
    </a>
</div>

<form method="GET" action="<?php echo e(route('mediciones.index')); ?>" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar paciente..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <?php if(isset($pacientes)): ?>
            <div class="col-md-3">
                <select name="paciente_id" class="form-select">
                    <option value="">Todos los pacientes</option>
                    <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php if(request('paciente_id') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-2">
                <input type="date" name="fecha_desde" class="form-control" value="<?php echo e(request('fecha_desde')); ?>" title="Desde">
            </div>
            <div class="col-md-2">
                <input type="date" name="fecha_hasta" class="form-control" value="<?php echo e(request('fecha_hasta')); ?>" title="Hasta">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
        </div>
        <input type="hidden" name="orden" value="<?php echo e($orden); ?>">
        <input type="hidden" name="dir" value="<?php echo e($dir); ?>">
    </div>
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-success">
            <tr>
                <?php
                    if (!function_exists('colLink')) {
                        function colLink($campo, $label, $orden, $dir) {
                            $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                            $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                            $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                            return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                        }
                    }
                ?>
                <th>Paciente</th>
                <th><?php echo colLink('fecha_medicion', 'Fecha', $orden, $dir); ?></th>
                <th><?php echo colLink('peso_kg', 'Peso (kg)', $orden, $dir); ?></th>
                <th><?php echo colLink('altura_cm', 'Altura (cm)', $orden, $dir); ?></th>
                <th><?php echo colLink('imc', 'IMC', $orden, $dir); ?></th>
                <th><?php echo colLink('porcentaje_grasa', '% Grasa', $orden, $dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $mediciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($m->paciente->nombre_completo ?? '—'); ?></td>
                    <td><?php echo e($m->fecha_medicion->format('d/m/Y')); ?></td>
                    <td><?php echo e($m->peso_kg); ?></td>
                    <td><?php echo e($m->altura_cm); ?></td>
                    <td><span class="badge bg-info text-dark"><?php echo e($m->imc ? number_format($m->imc, 1) : '—'); ?></span></td>
                    <td><?php echo e($m->porcentaje_grasa !== null ? $m->porcentaje_grasa . ' %' : '—'); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('mediciones.edit', $m)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('mediciones.destroy', $m)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta medición?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No hay mediciones registradas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    <?php echo e($mediciones->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/mediciones/index.blade.php ENDPATH**/ ?>