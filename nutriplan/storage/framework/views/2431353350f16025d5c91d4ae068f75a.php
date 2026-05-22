<?php $__env->startSection('title','Mensajes'); ?>
<?php $__env->startSection('breadcrumb','Mensajes'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .chat-wrap { height:calc(100vh - 220px); min-height:400px; display:flex; flex-direction:column; background:#fff; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,.08); overflow:hidden; }
    .chat-hdr  { background:linear-gradient(135deg,#1a3d2b,#2e7d52); color:#fff; padding:.9rem 1.2rem; display:flex; align-items:center; gap:.7rem; flex-shrink:0; }
    .chat-msgs { flex:1; overflow-y:auto; padding:1rem; background:#f8f9fa; }
    .msg-bubble{ max-width:62%; padding:.5rem .85rem; border-radius:16px; margin-bottom:.5rem; font-size:.9rem; }
    .msg-out   { background:#2e7d52; color:#fff; margin-left:auto; border-bottom-right-radius:4px; }
    .msg-in    { background:#fff; border:1px solid #e2e8f0; border-bottom-left-radius:4px; }
    .msg-time  { font-size:.68rem; opacity:.6; display:block; margin-top:.15rem; text-align:right; }
    .chat-foot { border-top:1px solid #e2e8f0; background:#fff; padding:.7rem 1rem; flex-shrink:0; }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<h4 class="fw-bold mb-4">Mensajes con mi nutricionista</h4>

<?php if($paciente->nutricionista): ?>
<div class="chat-wrap">
    <div class="chat-hdr">
        <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['foto' => $paciente->nutricionista?->foto,'nombre' => $paciente->nutricionista?->nombre_completo ?? 'N','size' => 38,'bg' => '#fff','color' => '#2e7d52']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['foto' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($paciente->nutricionista?->foto),'nombre' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($paciente->nutricionista?->nombre_completo ?? 'N'),'size' => 38,'bg' => '#fff','color' => '#2e7d52']); ?>
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
        <div>
            <div class="fw-semibold"><?php echo e($paciente->nutricionista?->nombre_completo); ?></div>
            <div style="font-size:.75rem;opacity:.8"><?php echo e($conversacion->colaboracion ?? 'Conversación directa'); ?></div>
        </div>
    </div>
    <div class="chat-msgs" id="chatMsgs">
        <?php $__empty_1 = true; $__currentLoopData = $mensajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $esMio = $msg->autor_user_id === Auth::id(); ?>
            <div class="d-flex <?php echo e($esMio ? 'justify-content-end' : 'justify-content-start'); ?>">
                <div class="msg-bubble <?php echo e($esMio ? 'msg-out' : 'msg-in'); ?>">
                    <?php if(!$esMio): ?>
                        <span style="font-size:.72rem;color:#2e7d52;font-weight:600;display:block;margin-bottom:.1rem">
                            <?php echo e($msg->autor?->name ?? $paciente->nutricionista?->nombre_completo); ?>

                        </span>
                    <?php endif; ?>
                    <?php echo e($msg->contenido); ?>

                    <span class="msg-time"><?php echo e($msg->enviado_en?->format('d/m H:i') ?? $msg->created_at->format('d/m H:i')); ?></span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-chat-dots fs-2 d-block mb-2 opacity-25"></i>
                Aún no hay mensajes. ¡Escribe el primero!
            </div>
        <?php endif; ?>
    </div>
    <div class="chat-foot">
        <form method="POST" action="<?php echo e(route('paciente.enviar-mensaje')); ?>" class="d-flex gap-2">
            <?php echo csrf_field(); ?>
            <?php if($conversacion): ?>
                <input type="hidden" name="conversacion_id" value="<?php echo e($conversacion->id); ?>">
            <?php endif; ?>
            <input type="hidden" name="paciente_id" value="<?php echo e($paciente->id); ?>">
            <input type="text" name="contenido" class="form-control"
                   placeholder="Escribe un mensaje..." required autocomplete="off" maxlength="2000">
            <button type="submit" class="btn btn-success px-3">
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>
</div>
<?php else: ?>
<div class="card text-center py-5">
    <div class="card-body">
        <i class="bi bi-chat-dots fs-1 text-success opacity-50 d-block mb-3"></i>
        <h5 class="fw-bold">Aún no tienes nutricionista asignado</h5>
        <p class="text-muted">Cuando se te asigne un nutricionista podrás comunicarte aquí.</p>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>const m=document.getElementById('chatMsgs');if(m)m.scrollTop=m.scrollHeight;</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.paciente', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/paciente/mis-mensajes.blade.php ENDPATH**/ ?>