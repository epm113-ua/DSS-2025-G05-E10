<?php $__env->startSection('titulo','Pacientes'); ?>
<?php $__env->startSection('breadcrumb','Pacientes'); ?>
<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-success"></i>Pacientes</h4>
    <?php if(Auth::user()->esAdmin()): ?>
        <a href="<?php echo e(route('pacientes.create')); ?>" class="btn btn-success btn-sm"><i class="bi bi-plus-lg me-1"></i>Nuevo paciente</a>
    <?php endif; ?>
</div>

<form method="GET" action="<?php echo e(route('pacientes.index')); ?>" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Buscar por nombre..." value="<?php echo e(request('buscar')); ?>">
            </div>
            <?php if(Auth::user()->esAdmin()): ?>
            <div class="col-md-3">
                <select name="nutricionista_id" class="form-select form-select-sm">
                    <option value="">Todos los nutricionistas</option>
                    <?php $__currentLoopData = $nutricionistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($n->id); ?>" <?php if(request('nutricionista_id')==$n->id): echo 'selected'; endif; ?>><?php echo e($n->nombre_completo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-2">
                <input type="text" name="ciudad" class="form-control form-control-sm" placeholder="Ciudad..." value="<?php echo e(request('ciudad')); ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('pacientes.index')); ?>" class="btn btn-outline-secondary btn-sm">Limpiar</a>
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
                    <th>Nombre</th>
                    <th>Nutricionista</th>
                    <th>Ciudad</th>
                    <th>Objetivos</th>
                    <th>Cuenta</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-semibold">
                        <?php if($p->foto): ?>
                            <img src="<?php echo e(asset('storage/'.$p->foto)); ?>" class="rounded-circle me-2" style="width:30px;height:30px;object-fit:cover" alt="foto">
                        <?php else: ?>
                            <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center me-2 fw-bold flex-shrink-0"
                                  style="width:30px;height:30px;font-size:.65rem;vertical-align:middle">
                                <?php echo e(strtoupper(substr($p->nombre_completo,0,1))); ?><?php echo e(strtoupper(substr(strstr($p->nombre_completo,' '),1,1))); ?>

                            </span>
                        <?php endif; ?>
                        <?php echo e($p->nombre_completo); ?>

                    </td>
                    <td class="text-muted small"><?php echo e($p->nutricionista?->nombre_completo ?? '—'); ?></td>
                    <td class="text-muted small"><?php echo e($p->ciudad ?? '—'); ?></td>
                    <td class="text-muted small"><?php echo e(\Illuminate\Support\Str::limit($p->objetivos ?? '—', 30)); ?></td>
                    <td>
                        <?php if($p->user): ?>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">Tiene acceso</span>
                        <?php else: ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 small">Sin acceso</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <a href="<?php echo e(route('pacientes.show',$p)); ?>" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-eye"></i></a>
                        <a href="<?php echo e(route('pacientes.edit',$p)); ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                        <?php if(Auth::user()->esAdmin()): ?>
                        <form action="<?php echo e(route('pacientes.destroy',$p)); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar a <?php echo e($p->nombre_completo); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No hay pacientes registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($pacientes->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/pacientes/index.blade.php ENDPATH**/ ?>