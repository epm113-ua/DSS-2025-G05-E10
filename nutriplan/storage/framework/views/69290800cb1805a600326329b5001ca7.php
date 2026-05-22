<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'foto'   => null,
    'nombre' => '',
    'size'   => 40,
    'letras' => 2,
    'bg'     => '#2e7d52',
    'color'  => '#fff',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'foto'   => null,
    'nombre' => '',
    'size'   => 40,
    'letras' => 2,
    'bg'     => '#2e7d52',
    'color'  => '#fff',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $iniciales = strtoupper(mb_substr(trim($nombre) !== '' ? trim($nombre) : '?', 0, (int) $letras));
    $dim       = (int) $size;
    $fontSize  = round($dim * 0.4, 1);
    $tieneFoto = filled($foto);
?>
<span <?php echo e($attributes->class(['np-avatar'])); ?>

      style="display:inline-flex;align-items:center;justify-content:center;flex:0 0 <?php echo e($dim); ?>px;width:<?php echo e($dim); ?>px;height:<?php echo e($dim); ?>px;min-width:<?php echo e($dim); ?>px;border-radius:50%;background:<?php echo e($bg); ?>;color:<?php echo e($color); ?>;font-weight:700;font-size:<?php echo e($fontSize); ?>px;line-height:1;overflow:hidden;vertical-align:middle;text-align:center;">
    <?php if($tieneFoto): ?>
        <img src="<?php echo e(asset('storage/'.$foto)); ?>"
             alt="<?php echo e($nombre); ?>"
             style="width:<?php echo e($dim); ?>px;height:<?php echo e($dim); ?>px;object-fit:cover;display:block;border-radius:50%;"
             onerror="this.style.display='none';this.parentNode.textContent='<?php echo e($iniciales); ?>';">
    <?php else: ?>
        <?php echo e($iniciales); ?>

    <?php endif; ?>
</span>
<?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/components/avatar.blade.php ENDPATH**/ ?>