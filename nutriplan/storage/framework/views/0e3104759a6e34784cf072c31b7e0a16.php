<?php $__env->startSection('titulo', 'Nutricionistas'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-person-badge me-2 text-success"></i>Nutricionistas</h2>
    <a href="<?php echo e(route('nutricionistas.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nuevo nutricionista
    </a>
</div>

<form method="GET" action="<?php echo e(route('nutricionistas.index')); ?>" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, especialidad o ciudad…"
               value="<?php echo e(request('buscar')); ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="<?php echo e(route('nutricionistas.index')); ?>" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                    function sortLink($campo, $label, $orden, $dir) {
                        $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                        $icon    = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                        $url     = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir, 'pagina' => 1]);
                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                    }
                ?>
                <th><?php echo sortLink('nombre_completo', 'Nombre', $orden, $dir); ?></th>
                <th><?php echo sortLink('especialidad', 'Especialidad', $orden, $dir); ?></th>
                <th><?php echo sortLink('ciudad', 'Ciudad', $orden, $dir); ?></th>
                <th>Tienda</th>
                <th><?php echo sortLink('valoracion_media', 'Valoración', $orden, $dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $nutricionistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($n->nombre_completo); ?></td>
                    <td><?php echo e($n->especialidad); ?></td>
                    <td><?php echo e($n->ciudad); ?></td>
                    <td><?php echo e($n->tienda->nombre_tienda ?? '—'); ?></td>
                    <td>
                        <span class="badge bg-success"><?php echo e(number_format($n->valoracion_media, 1)); ?> / 5</span>
                    </td>
                    <td class="text-end">
                        <a href="<?php echo e(route('nutricionistas.edit', $n)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('nutricionistas.destroy', $n)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este nutricionista?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No hay nutricionistas registrados.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/nutricionistas/index.blade.php ENDPATH**/ ?>