<?php $__env->startSection('titulo', 'Tiendas'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-shop me-2 text-success"></i>Tiendas</h2>
    <a href="<?php echo e(route('tiendas.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva tienda
    </a>
</div>

<form method="GET" action="<?php echo e(route('tiendas.index')); ?>" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre…"
               value="<?php echo e(request('buscar')); ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="<?php echo e(route('tiendas.index')); ?>" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                <th><?php echo colLink('nombre_tienda', 'Nombre', $orden, $dir); ?></th>
                <th><?php echo colLink('nutricionistas_count', 'Nutricionistas', $orden, $dir); ?></th>
                <th><?php echo colLink('ingredientes_count', 'Ingredientes', $orden, $dir); ?></th>
                <th><?php echo colLink('ofertas_count', 'Ofertas', $orden, $dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $tiendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($t->nombre_tienda); ?></td>
                    <td><span class="badge bg-secondary"><?php echo e($t->nutricionistas_count); ?></span></td>
                    <td><span class="badge bg-secondary"><?php echo e($t->ingredientes_count); ?></span></td>
                    <td><span class="badge bg-secondary"><?php echo e($t->ofertas_count); ?></span></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('tiendas.edit', $t)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('tiendas.destroy', $t)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta tienda?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No hay tiendas registradas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    <?php echo e($tiendas->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/tiendas/index.blade.php ENDPATH**/ ?>