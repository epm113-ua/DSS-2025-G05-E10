<?php $__env->startSection('titulo', 'Citas'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-calendar-check me-2 text-success"></i>Citas</h2>
    <a href="<?php echo e(route('citas.create')); ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva cita
    </a>
</div>

<form method="GET" action="<?php echo e(route('citas.index')); ?>" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <div class="col-md-2">
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente"  <?php if(request('estado')==='pendiente'): echo 'selected'; endif; ?>>Pendiente</option>
                    <option value="completada" <?php if(request('estado')==='completada'): echo 'selected'; endif; ?>>Completada</option>
                    <option value="cancelada"  <?php if(request('estado')==='cancelada'): echo 'selected'; endif; ?>>Cancelada</option>
                </select>
            </div>
            <?php if(isset($nutricionistas)): ?>
            <div class="col-md-2">
                <select name="nutricionista_id" class="form-select">
                    <option value="">Todos los nutricionistas</option>
                    <?php $__currentLoopData = $nutricionistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($n->id); ?>" <?php if(request('nutricionista_id') == $n->id): echo 'selected'; endif; ?>><?php echo e($n->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <?php if(isset($pacientes)): ?>
            <div class="col-md-2">
                <select name="paciente_id" class="form-select">
                    <option value="">Todos los pacientes</option>
                    <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php if(request('paciente_id') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-3 d-flex gap-2">
                <input type="date" name="fecha_desde" class="form-control" value="<?php echo e(request('fecha_desde')); ?>" title="Desde">
                <input type="date" name="fecha_hasta" class="form-control" value="<?php echo e(request('fecha_hasta')); ?>" title="Hasta">
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            <a href="<?php echo e(route('citas.index')); ?>" class="btn btn-outline-secondary">Limpiar</a>
        </div>
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
                    if (!function_exists('colLink')) {
                        function colLink($campo, $label, $orden, $dir) {
                            $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                            $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                            $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                            return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                        }
                    }
                ?>
                <th><?php echo colLink('inicio', 'Inicio', $orden, $dir); ?></th>
                <th><?php echo colLink('fin', 'Fin', $orden, $dir); ?></th>
                <th>Paciente</th>
                <th>Nutricionista</th>
                <th><?php echo colLink('estado', 'Estado', $orden, $dir); ?></th>
                <th><?php echo colLink('motivo', 'Motivo', $orden, $dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $badgeEstado = ['pendiente' => 'warning', 'completada' => 'success', 'cancelada' => 'danger'];
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($c->inicio->format('d/m/Y H:i')); ?></td>
                    <td><?php echo e($c->fin->format('d/m/Y H:i')); ?></td>
                    <td><?php echo e($c->paciente->nombre_completo ?? '—'); ?></td>
                    <td><?php echo e($c->nutricionista->nombre_completo ?? '—'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($badgeEstado[$c->estado] ?? 'secondary'); ?>"><?php echo e(ucfirst($c->estado)); ?></span>
                    </td>
                    <td><?php echo e(Str::limit($c->motivo, 40)); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('citas.edit', $c)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('citas.destroy', $c)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta cita?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No hay citas registradas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    <?php echo e($citas->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/citas/index.blade.php ENDPATH**/ ?>