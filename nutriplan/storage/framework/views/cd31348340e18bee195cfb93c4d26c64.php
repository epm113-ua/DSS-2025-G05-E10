<?php $__env->startSection('titulo', 'Conversaciones'); ?>
<?php $__env->startSection('breadcrumb', 'Conversaciones'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-chat-dots me-2 text-success"></i>Conversaciones</h4>
    <a href="<?php echo e(route('conversaciones.create')); ?>" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nueva conversación
    </a>
</div>

<form method="GET" action="<?php echo e(route('conversaciones.index')); ?>" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control form-control-sm"
                       placeholder="Buscar por colaboración o paciente…" value="<?php echo e(request('buscar')); ?>">
            </div>
            <div class="col-md-3">
                <select name="paciente_id" class="form-select form-select-sm">
                    <option value="">Todos los pacientes</option>
                    <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php if(request('paciente_id') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-search me-1"></i>Buscar</button>
                <a href="<?php echo e(route('conversaciones.index')); ?>" class="btn btn-outline-secondary btn-sm ms-1">Limpiar</a>
            </div>
        </div>
        <input type="hidden" name="orden" value="<?php echo e($orden); ?>">
        <input type="hidden" name="dir"   value="<?php echo e($dir); ?>">
    </div>
</form>

<div class="card">
    <div class="table-responsive">
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
                <th><?php echo colLink('creado_en','Fecha',$orden,$dir); ?></th>
                <th>Paciente</th>
                <th>Nutricionista</th>
                <th><?php echo colLink('colaboracion','Colaboración',$orden,$dir); ?></th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $conversaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted small"><?php echo e($c->creado_en?->format('d/m/Y H:i') ?? $c->created_at->format('d/m/Y H:i')); ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if($c->paciente?->foto): ?>
                                <img src="<?php echo e(asset('storage/'.$c->paciente->foto)); ?>" class="rounded-circle" style="width:26px;height:26px;object-fit:cover">
                            <?php else: ?>
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                     style="width:26px;height:26px;font-size:.6rem">
                                    <?php echo e(strtoupper(substr($c->paciente?->nombre_completo ?? '?',0,1))); ?><?php echo e(strtoupper(substr(strstr($c->paciente?->nombre_completo ?? '',  ' '),1,1))); ?>

                                </div>
                            <?php endif; ?>
                            <span class="small"><?php echo e($c->paciente?->nombre_completo ?? '—'); ?></span>
                        </div>
                    </td>
                    <td class="text-muted small"><?php echo e($c->nutricionista?->nombre_completo ?? '—'); ?></td>
                    <td class="small"><?php echo e(Str::limit($c->colaboracion, 40)); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('conversaciones.show', $c)); ?>" class="btn btn-sm btn-outline-success me-1" title="Ver chat">
                            <i class="bi bi-chat-text"></i>
                        </a>
                        <a href="<?php echo e(route('conversaciones.edit', $c)); ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('conversaciones.destroy', $c)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta conversación y todos sus mensajes?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No hay conversaciones registradas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($conversaciones->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/conversaciones/index.blade.php ENDPATH**/ ?>