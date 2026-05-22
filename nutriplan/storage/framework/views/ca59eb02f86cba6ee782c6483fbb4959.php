<?php $__env->startSection('titulo','Mi Perfil'); ?>
<?php $__env->startSection('breadcrumb','Mi Perfil'); ?>
<?php $__env->startSection('contenido'); ?>
<h4 class="fw-bold mb-4">Mi Perfil</h4>
<div class="row g-4" style="max-width:800px">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-person-badge me-1"></i>Datos profesionales</div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('nutricionista.mi-perfil.update')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="text-center mb-3">
                        <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['foto' => $nutricionista->foto,'nombre' => $nutricionista->nombre_completo,'size' => 80]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['foto' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($nutricionista->foto),'nombre' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($nutricionista->nombre_completo),'size' => 80]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $attributes = $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b)): ?>
<?php $component = $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b; ?>
<?php unset($__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b); ?>
<?php endif; ?>
                    </div>

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
                        <label class="form-label small fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre_completo" class="form-control <?php $__errorArgs = ['nombre_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('nombre_completo', $nutricionista->nombre_completo)); ?>" required>
                        <?php $__errorArgs = ['nombre_completo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Especialidad <span class="text-danger">*</span></label>
                        <input type="text" name="especialidad" class="form-control <?php $__errorArgs = ['especialidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('especialidad', $nutricionista->especialidad)); ?>" required>
                        <?php $__errorArgs = ['especialidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ciudad <span class="text-danger">*</span></label>
                        <input type="text" name="ciudad" class="form-control <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('ciudad', $nutricionista->ciudad)); ?>" required>
                        <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Correo electrónico</label>
                        <input type="email" class="form-control" value="<?php echo e(Auth::user()->email); ?>" disabled>
                        <div class="form-text">El email no puede cambiarse aquí.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Valoración</label>
                        <div class="d-flex align-items-center gap-2">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="bi bi-star<?php echo e($i <= $nutricionista->valoracion_media ? '-fill' : ''); ?> text-warning fs-5"></i>
                            <?php endfor; ?>
                            <span class="text-muted small ms-1"><?php echo e(number_format($nutricionista->valoracion_media,1)); ?> / 5</span>
                        </div>
                        <div class="form-text">La valoración la gestiona el administrador.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i>Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5 d-flex flex-column gap-3">
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-people me-1"></i>Mis pacientes</div>
            <div class="card-body text-center py-3">
                <div class="fs-2 fw-bold text-success"><?php echo e($nutricionista->pacientes()->count()); ?></div>
                <div class="text-muted small">pacientes asignados</div>
                <a href="<?php echo e(route('pacientes.index')); ?>" class="btn btn-outline-success btn-sm mt-2">Ver pacientes</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-shop me-1"></i>Tienda asignada</div>
            <div class="card-body text-center py-3">
                <div class="fw-semibold"><?php echo e($nutricionista->tienda?->nombre_tienda ?? 'Sin tienda asignada'); ?></div>
                <div class="text-muted small mt-1"><?php echo e($nutricionista->ciudad); ?></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/nutricionistas/mi-perfil.blade.php ENDPATH**/ ?>