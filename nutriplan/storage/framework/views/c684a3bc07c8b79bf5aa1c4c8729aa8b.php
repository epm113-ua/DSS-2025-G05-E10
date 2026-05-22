<?php $__env->startSection('titulo', 'Planes Semanales'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-calendar-week me-2 text-success"></i>Planes Semanales</h2>
    <a href="<?php echo e(route('plan-semanales.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo plan
    </a>
</div>

<form method="GET" action="<?php echo e(route('plan-semanales.index')); ?>" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por notas o fecha…"
               value="<?php echo e(request('buscar')); ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="<?php echo e(route('plan-semanales.index')); ?>" class="btn btn-outline-secondary ms-1">Limpiar</a>
    </div>
    <input type="hidden" name="orden" value="<?php echo e($orden); ?>">
    <input type="hidden" name="dir"   value="<?php echo e($dir); ?>">
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-success">
            <tr>
                <?php
                    function colLink($campo, $label, $orden, $dir) {
                        $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                        $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                        $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                    }
                ?>
                <th><?php echo colLink('semana_inicio', 'Semana inicio', $orden, $dir); ?></th>
                <th>Cita / Paciente</th>
                <th><?php echo colLink('notas', 'Notas', $orden, $dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $planes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($p->semana_inicio); ?></td>
                    <td><?php echo e($p->cita->paciente->nombre_completo ?? 'Cita #' . $p->cita_id); ?></td>
                    <td><?php echo e(Str::limit($p->notas, 60) ?? '—'); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('plan-semanales.edit', $p)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('plan-semanales.destroy', $p)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este plan?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">No hay planes semanales registrados.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    <?php echo e($planes->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/plan-semanales/index.blade.php ENDPATH**/ ?>