<?php $__env->startSection('titulo','Mensajes'); ?>
<?php $__env->startSection('breadcrumb','Mensajes'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .chat-outer  { display:flex; height:calc(100vh - 140px); min-height:480px; background:#fff; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,.08); overflow:hidden; }
    .chat-side   { width:260px; flex-shrink:0; border-right:1px solid #e2e8f0; display:flex; flex-direction:column; }
    .chat-side-hdr { padding:.8rem 1rem; font-size:.8rem; font-weight:700; color:#2e7d52; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid #e2e8f0; }
    .chat-side-list{ flex:1; overflow-y:auto; }
    .chat-side-item{ display:flex; align-items:center; gap:.6rem; padding:.6rem 1rem; text-decoration:none; color:#374151; border-bottom:1px solid #f5f5f5; font-size:.85rem; transition:background .12s; }
    .chat-side-item:hover { background:#f0f9f4; color:#2e7d52; }
    .chat-side-item.active { background:#e8f5e9; color:#1a5c38; }
    .chat-side-item .nombre { font-weight:600; line-height:1.15; }
    .chat-side-item .sub { font-size:.7rem; color:#94a3b8; display:block; margin-top:.1rem; }
    .chat-main   { flex:1; display:flex; flex-direction:column; overflow:hidden; }
    .chat-hdr    { background:linear-gradient(135deg,#1a3d2b,#2e7d52); color:#fff; padding:.8rem 1.2rem; display:flex; align-items:center; gap:.7rem; flex-shrink:0; }
    .chat-msgs   { flex:1; overflow-y:auto; padding:1rem; background:#f8f9fa; }
    .msg-bubble  { max-width:62%; padding:.5rem .85rem; border-radius:16px; margin-bottom:.5rem; font-size:.88rem; word-wrap:break-word; }
    .msg-out     { background:#2e7d52; color:#fff; margin-left:auto; border-bottom-right-radius:4px; }
    .msg-in      { background:#fff; border:1px solid #e2e8f0; border-bottom-left-radius:4px; }
    .msg-time    { font-size:.67rem; opacity:.6; display:block; margin-top:.15rem; text-align:right; }
    .chat-foot   { border-top:1px solid #e2e8f0; background:#fff; padding:.7rem 1rem; flex-shrink:0; }
    .search-box  { padding:.5rem; border-bottom:1px solid #f0f0f0; }
    .search-box input { font-size:.8rem; }
    .chat-empty  { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#94a3b8; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<h4 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-success"></i>Mensajes</h4>

<div class="chat-outer">

    
    <div class="chat-side">
        <div class="chat-side-hdr">Chats</div>
        <div class="search-box">
            <input type="text" class="form-control form-control-sm" id="buscarChat" placeholder="Buscar paciente...">
        </div>
        <div class="chat-side-list" id="chatList">
            <?php $__empty_1 = true; $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $conv = $convPorPaciente->get($p->id); ?>
                <a href="<?php echo e(route('mensajes.chat', ['paciente' => $p->id])); ?>"
                   class="chat-side-item <?php echo e($pacienteActivo && $pacienteActivo->id === $p->id ? 'active' : ''); ?>"
                   data-nombre="<?php echo e(strtolower($p->nombre_completo)); ?>">
                    <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['foto' => $p->foto,'nombre' => $p->nombre_completo,'size' => 40]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['foto' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->foto),'nombre' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->nombre_completo),'size' => 40]); ?>
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
                    <div class="overflow-hidden">
                        <div class="nombre text-truncate"><?php echo e($p->nombre_completo); ?></div>
                        <span class="sub">
                            <?php if($conv): ?>
                                <?php echo e($conv->updated_at->diffForHumans()); ?>

                            <?php else: ?>
                                Sin mensajes todavía
                            <?php endif; ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-muted small p-3">No tienes pacientes asignados.</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="chat-main">
        <?php if($pacienteActivo && $conversacion): ?>
            <div class="chat-hdr">
                <?php if (isset($component)) { $__componentOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ca5b43b8fff8bb34ab2ba4eb4bdd67b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatar','data' => ['foto' => $pacienteActivo->foto,'nombre' => $pacienteActivo->nombre_completo,'size' => 38,'bg' => '#fff','color' => '#2e7d52']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['foto' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pacienteActivo->foto),'nombre' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pacienteActivo->nombre_completo),'size' => 38,'bg' => '#fff','color' => '#2e7d52']); ?>
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
                    <div class="fw-semibold"><?php echo e($pacienteActivo->nombre_completo); ?></div>
                    <div style="font-size:.75rem;opacity:.8"><?php echo e($conversacion->colaboracion ?? 'Conversación directa'); ?></div>
                </div>
            </div>

            <div class="chat-msgs" id="chatMsgs">
                <?php $__empty_1 = true; $__currentLoopData = $mensajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $esMio = $msg->autor_user_id === Auth::id(); ?>
                    <div class="d-flex <?php echo e($esMio ? 'justify-content-end' : 'justify-content-start'); ?>">
                        <div class="msg-bubble <?php echo e($esMio ? 'msg-out' : 'msg-in'); ?>">
                            <?php if(!$esMio): ?>
                                <span style="font-size:.7rem;color:#2e7d52;font-weight:600;display:block;margin-bottom:.1rem">
                                    <?php echo e($msg->autor?->name ?? $pacienteActivo->nombre_completo); ?>

                                </span>
                            <?php endif; ?>
                            <?php echo e($msg->contenido); ?>

                            <span class="msg-time"><?php echo e($msg->enviado_en?->format('d/m H:i') ?? $msg->created_at->format('d/m H:i')); ?></span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-dots fs-2 d-block mb-2 opacity-25"></i>
                        Sin mensajes aún. ¡Escribe el primero!
                    </div>
                <?php endif; ?>
            </div>

            <div class="chat-foot">
                <form method="POST" action="<?php echo e(route('mensajes.store')); ?>" class="d-flex gap-2">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="conversacion_id" value="<?php echo e($conversacion->id); ?>">
                    <input type="hidden" name="paciente_id" value="<?php echo e($pacienteActivo->id); ?>">
                    <input type="text" name="contenido" class="form-control"
                           placeholder="Escribe un mensaje..." required autocomplete="off" maxlength="2000">
                    <button type="submit" class="btn btn-success px-3">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="chat-empty">
                <i class="bi bi-chat-square-text fs-1 opacity-25 mb-2"></i>
                <div>Selecciona un paciente para empezar a chatear.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const msgs = document.getElementById('chatMsgs');
    if (msgs) msgs.scrollTop = msgs.scrollHeight;

    const buscar = document.getElementById('buscarChat');
    if (buscar) {
        buscar.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.chat-side-item[data-nombre]').forEach(el => {
                el.style.display = el.dataset.nombre.includes(q) ? '' : 'none';
            });
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/mensajes/chat.blade.php ENDPATH**/ ?>