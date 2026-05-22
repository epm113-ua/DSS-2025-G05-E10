<?php $__env->startSection('titulo', 'Recetas'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-journal-richtext me-2 text-success"></i>Recetas</h2>
    <a href="<?php echo e(route('recetas.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva receta
    </a>
</div>

<form method="GET" action="<?php echo e(route('recetas.index')); ?>" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o preparación..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <?php if(isset($nutricionistas)): ?>
            <div class="col-md-4">
                <select name="nutricionista_id" class="form-select">
                    <option value="">Todos los nutricionistas</option>
                    <?php $__currentLoopData = $nutricionistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($n->id); ?>" <?php if(request('nutricionista_id') == $n->id): echo 'selected'; endif; ?>><?php echo e($n->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-3">
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
                <th><?php echo colLink('nombre', 'Nombre', $orden, $dir); ?></th>
                <th>Nutricionista</th>
                <th><?php echo colLink('calorias_kcal', 'Kcal', $orden, $dir); ?></th>
                <th><?php echo colLink('carbohidratos_g', 'Carbohidratos (g)', $orden, $dir); ?></th>
                <th><?php echo colLink('grasas_g', 'Grasas (g)', $orden, $dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $recetas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($r->nombre); ?></td>
                    <td><?php echo e($r->nutricionista->nombre_completo ?? '—'); ?></td>
                    <td><?php echo e($r->calorias_kcal); ?></td>
                    <td><?php echo e(number_format($r->carbohidratos_g, 1)); ?></td>
                    <td><?php echo e(number_format($r->grasas_g, 1)); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('recetas.edit', $r)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('recetas.destroy', $r)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta receta?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No hay recetas registradas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    <?php echo e($recetas->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/recetas/index.blade.php ENDPATH**/ ?>