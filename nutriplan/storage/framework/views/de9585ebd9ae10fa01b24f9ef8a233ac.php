<?php $__env->startSection('title','Mi Perfil'); ?>
<?php $__env->startSection('breadcrumb','Mi Perfil'); ?>
<?php $__env->startSection('contenido'); ?>
<h4 class="fw-bold mb-4">Mi Perfil</h4>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-person me-1"></i>Datos personales</div>
            <div class="card-body p-4">
                
                <form method="POST" action="<?php echo e(route('paciente.mi-perfil.update')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <?php if($paciente->foto): ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo e(asset('storage/'.$paciente->foto)); ?>" class="rounded-circle"
                                 style="width:80px;height:80px;object-fit:cover" alt="Foto">
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Foto de perfil</label>
                        <input type="file" name="foto" class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                        <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre completo</label>
                        <input type="text" name="name" class="form-control" value="<?php echo e(Auth::user()->name); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Correo electrónico</label>
                        <input type="email" class="form-control" value="<?php echo e(Auth::user()->email); ?>" disabled>
                        <div class="form-text">El email no puede cambiarse aquí.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento"
                               class="form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e($paciente->fecha_nacimiento?->format('Y-m-d')); ?>">
                        <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ciudad</label>
                        <input type="text" name="ciudad"
                               class="form-control <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('ciudad',$paciente->ciudad)); ?>">
                        <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Objetivos</label>
                        <textarea name="objetivos"
                                  class="form-control <?php $__errorArgs = ['objetivos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  rows="3"><?php echo e(old('objetivos',$paciente->objetivos)); ?></textarea>
                        <?php $__errorArgs = ['objetivos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-person-badge me-1"></i>Nutricionista asignado/a</div>
            <div class="card-body text-center py-4">
                <?php if($paciente->nutricionista?->foto): ?>
                    <img src="<?php echo e(asset('storage/'.$paciente->nutricionista->foto)); ?>"
                         class="rounded-circle mb-3" style="width:64px;height:64px;object-fit:cover">
                <?php else: ?>
                    <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:64px;height:64px;font-size:1.5rem;font-weight:700">
                        <?php echo e(strtoupper(substr($paciente->nutricionista?->nombre_completo ?? 'N',0,1))); ?>

                    </div>
                <?php endif; ?>
                <h6 class="fw-bold mb-1"><?php echo e($paciente->nutricionista?->nombre_completo ?? '—'); ?></h6>
                <p class="text-muted small mb-2"><?php echo e($paciente->nutricionista?->especialidad); ?></p>
                <span class="badge bg-light text-muted border">
                    <i class="bi bi-lock me-1"></i>Asignación permanente
                </span>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mi-perfil.blade.php ENDPATH**/ ?>