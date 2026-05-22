<?php $__env->startSection('titulo','Chat'); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .chat-outer  { display:flex; height:calc(100vh - 120px); min-height:450px; background:#fff; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,.08); overflow:hidden; }
    .chat-side   { width:230px; flex-shrink:0; border-right:1px solid #e2e8f0; display:flex; flex-direction:column; }
    .chat-side-hdr { padding:.8rem 1rem; font-size:.8rem; font-weight:700; color:#2e7d52; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid #e2e8f0; flex-shrink:0; }
    .chat-side-list{ flex:1; overflow-y:auto; }
    .chat-side-item{ display:flex; align-items:center; gap:.55rem; padding:.6rem .9rem; text-decoration:none; color:#374151; border-bottom:1px solid #f5f5f5; font-size:.83rem; transition:background .12s; cursor:pointer; }
    .chat-side-item:hover { background:#f0f9f4; color:#2e7d52; }
    .chat-side-item.active { background:#e8f5e9; color:#1a5c38; font-weight:600; }
    .chat-side-item .sub { font-size:.7rem; color:#94a3b8; display:block; margin-top:.1rem; }
    .chat-side-avatar { width:32px; height:32px; border-radius:50%; flex-shrink:0; object-fit:cover; }
    .chat-side-initials { width:32px; height:32px; border-radius:50%; background:#2e7d52; color:#fff; font-size:.68rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .search-box  { padding:.5rem; border-bottom:1px solid #f0f0f0; flex-shrink:0; }
    .search-box input { font-size:.8rem; }
    .chat-main   { flex:1; display:flex; flex-direction:column; overflow:hidden; }
    .chat-hdr    { background:linear-gradient(135deg,#1a3d2b,#2e7d52); color:#fff; padding:.8rem 1.2rem; display:flex; align-items:center; gap:.7rem; flex-shrink:0; }
    .chat-msgs   { flex:1; overflow-y:auto; padding:1rem; background:#f8f9fa; }
    .msg-bubble  { max-width:62%; padding:.5rem .85rem; border-radius:16px; margin-bottom:.5rem; font-size:.88rem; }
    .msg-out     { background:#2e7d52; color:#fff; margin-left:auto; border-bottom-right-radius:4px; }
    .msg-in      { background:#fff; border:1px solid #e2e8f0; border-bottom-left-radius:4px; }
    .msg-time    { font-size:.67rem; opacity:.6; display:block; margin-top:.15rem; text-align:right; }
    .chat-foot   { border-top:1px solid #e2e8f0; background:#fff; padding:.7rem 1rem; flex-shrink:0; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<div class="chat-outer">

    
    <?php if(Auth::user()->esNutricionista()): ?>
    <div class="chat-side">
        <div class="chat-side-hdr">Chats</div>
        <div class="search-box">
            <input type="text" class="form-control form-control-sm" id="buscarChat" placeholder="Buscar paciente...">
        </div>
        <div class="chat-side-list" id="chatList">
            <?php $__empty_1 = true; $__currentLoopData = $conversaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $pac = $c->paciente;
                $initials = $pac
                    ? strtoupper(substr($pac->nombre_completo,0,1)) . strtoupper(substr(strstr($pac->nombre_completo,' ') ?: ' ',1,1))
                    : '?';
            ?>
            <a href="<?php echo e(route('conversaciones.show', $c->id)); ?>"
               class="chat-side-item <?php echo e($c->id === $conversacion->id ? 'active' : ''); ?>"
               data-nombre="<?php echo e(strtolower($pac->nombre_completo ?? '')); ?>">
                <?php if($pac && $pac->foto): ?>
                    <img src="<?php echo e(asset('storage/'.$pac->foto)); ?>" class="chat-side-avatar" alt="foto">
                <?php else: ?>
                    <div class="chat-side-initials"><?php echo e($initials); ?></div>
                <?php endif; ?>
                <div>
                    <div><?php echo e($pac->nombre_completo ?? 'Paciente'); ?></div>
                    <span class="sub"><?php echo e($c->updated_at->diffForHumans()); ?></span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-muted small p-3">Sin conversaciones.</div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="chat-main">
        
        <div class="chat-hdr">
            <?php
                $pacHdr = $conversacion->paciente;
                $hdrInitials = $pacHdr
                    ? strtoupper(substr($pacHdr->nombre_completo,0,1)) . strtoupper(substr(strstr($pacHdr->nombre_completo,' ') ?: ' ',1,1))
                    : '?';
            ?>
            <?php if($pacHdr && $pacHdr->foto): ?>
                <img src="<?php echo e(asset('storage/'.$pacHdr->foto)); ?>" class="rounded-circle flex-shrink-0" style="width:38px;height:38px;object-fit:cover" alt="foto">
            <?php else: ?>
                <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                     style="width:38px;height:38px;font-size:.78rem">
                    <?php echo e($hdrInitials); ?>

                </div>
            <?php endif; ?>
            <div>
                <div class="fw-semibold"><?php echo e($pacHdr->nombre_completo ?? 'Paciente'); ?></div>
                <div style="font-size:.75rem;opacity:.8">
                    <?php if($conversacion->nutricionista): ?>
                        <?php echo e($conversacion->nutricionista->nombre_completo); ?> —
                    <?php endif; ?>
                    <?php echo e($conversacion->colaboracion ?? 'Conversación directa'); ?>

                </div>
            </div>
        </div>

        
        <div class="chat-msgs" id="chatMsgs">
            <?php $__empty_1 = true; $__currentLoopData = $mensajes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $esMio = $msg->autor_user_id === Auth::id(); ?>
                <div class="d-flex <?php echo e($esMio ? 'justify-content-end' : 'justify-content-start'); ?>">
                    <div class="msg-bubble <?php echo e($esMio ? 'msg-out' : 'msg-in'); ?>">
                        <?php if(!$esMio): ?>
                            <span style="font-size:.7rem;color:#2e7d52;font-weight:600;display:block;margin-bottom:.1rem">
                                <?php echo e($msg->autor?->name ?? 'Paciente'); ?>

                            </span>
                        <?php endif; ?>
                        <?php echo e($msg->contenido); ?>

                        <span class="msg-time"><?php echo e($msg->enviado_en?->format('H:i') ?? $msg->created_at->format('H:i')); ?></span>
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
                <input type="text" name="contenido" class="form-control"
                       placeholder="Escribe un mensaje..." required autocomplete="off">
                <button type="submit" class="btn btn-success px-3">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const msgs = document.getElementById('chatMsgs');
    if (msgs) msgs.scrollTop = msgs.scrollHeight;

    const buscarChat = document.getElementById('buscarChat');
    if (buscarChat) {
        buscarChat.addEventListener('input', function(){
            const q = this.value.toLowerCase();
            document.querySelectorAll('.chat-side-item[data-nombre]').forEach(el => {
                el.style.display = el.dataset.nombre.includes(q) ? '' : 'none';
            });
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /mnt/c/Users/bellf/OneDrive/Escritorio/Universidad/Curso 25-26/Segundo Cuatrimestre/DSS/Prácticas/Tareas/DSS-2025-G05-E10/nutriplan/resources/views/conversaciones/show.blade.php ENDPATH**/ ?>