<?php $__env->startSection('titulo', isset($pago) ? 'Editar pago' : 'Nuevo pago'); ?>
<?php $__env->startSection('breadcrumb', isset($pago) ? 'Pagos › Editar' : 'Pagos › Nuevo'); ?>
<?php $__env->startSection('contenido'); ?>
<h4 class="fw-bold mb-4"><i class="bi bi-credit-card me-2 text-success"></i><?php echo e(isset($pago) ? 'Editar pago' : 'Nuevo pago'); ?></h4>
<div class="card" style="max-width:520px">
    <div class="card-body p-4">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
        <?php endif; ?>
        <form action="<?php echo e(isset($pago) ? route('pagos.update',$pago) : route('pagos.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($pago)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Factura <span class="text-danger">*</span></label>
                <select name="factura_id" class="form-select <?php $__errorArgs = ['factura_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">— Seleccionar —</option>
                    <?php $__currentLoopData = $facturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($f->id); ?>" <?php if(old('factura_id',$pago->factura_id ?? '') == $f->id): echo 'selected'; endif; ?>>
                            <?php echo e($f->numero_factura); ?> — <?php echo e($f->paciente->nombre_completo ?? ''); ?> (<?php echo e(number_format($f->importe,2)); ?> €)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['factura_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Nombre del titular <span class="text-danger">*</span></label>
                <input type="text" name="nombre_titular" class="form-control <?php $__errorArgs = ['nombre_titular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('nombre_titular', $pago->nombre_titular ?? '')); ?>" required>
                <?php $__errorArgs = ['nombre_titular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold small">Importe (€) <span class="text-danger">*</span></label>
                    <input type="number" name="importe" step="0.01" min="0"
                           class="form-control <?php $__errorArgs = ['importe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           value="<?php echo e(old('importe', $pago->importe ?? '')); ?>" required>
                    <?php $__errorArgs = ['importe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold small">Forma de pago <span class="text-danger">*</span></label>
                    <select name="forma_pago" class="form-select <?php $__errorArgs = ['forma_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">— Seleccionar —</option>
                        <?php $__currentLoopData = $formas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($f); ?>" <?php if(old('forma_pago',$pago->forma_pago ?? '') == $f): echo 'selected'; endif; ?>><?php echo e($f); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['forma_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">Fecha de pago <span class="text-danger">*</span></label>
                <input type="datetime-local" name="fecha_pago"
                       class="form-control <?php $__errorArgs = ['fecha_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       value="<?php echo e(old('fecha_pago', isset($pago) ? $pago->fecha_pago->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i'))); ?>" required>
                <?php $__errorArgs = ['fecha_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i><?php echo e(isset($pago) ? 'Guardar cambios' : 'Registrar pago'); ?></button>
                <a href="<?php echo e(route('pagos.index')); ?>" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/pagos/form.blade.php ENDPATH**/ ?>