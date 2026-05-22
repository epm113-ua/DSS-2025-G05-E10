@extends('layouts.app')
@section('titulo','Mensajes')
@section('breadcrumb','Mensajes')
@section('styles')
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
@endsection

@section('contenido')
<h4 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2 text-success"></i>Mensajes</h4>

<div class="chat-outer">

    {{-- Sidebar: todos los pacientes del nutricionista --}}
    <div class="chat-side">
        <div class="chat-side-hdr">Chats</div>
        <div class="search-box">
            <input type="text" class="form-control form-control-sm" id="buscarChat" placeholder="Buscar paciente...">
        </div>
        <div class="chat-side-list" id="chatList">
            @forelse($pacientes as $p)
                @php $conv = $convPorPaciente->get($p->id); @endphp
                <a href="{{ route('mensajes.chat', ['paciente' => $p->id]) }}"
                   class="chat-side-item {{ $pacienteActivo && $pacienteActivo->id === $p->id ? 'active' : '' }}"
                   data-nombre="{{ strtolower($p->nombre_completo) }}">
                    <x-avatar :foto="$p->foto" :nombre="$p->nombre_completo" :size="40" />
                    <div class="overflow-hidden">
                        <div class="nombre text-truncate">{{ $p->nombre_completo }}</div>
                        <span class="sub">
                            @if($conv)
                                {{ $conv->updated_at->diffForHumans() }}
                            @else
                                Sin mensajes todavía
                            @endif
                        </span>
                    </div>
                </a>
            @empty
                <div class="text-muted small p-3">No tienes pacientes asignados.</div>
            @endforelse
        </div>
    </div>

    {{-- Panel principal del chat --}}
    <div class="chat-main">
        @if($pacienteActivo && $conversacion)
            <div class="chat-hdr">
                <x-avatar :foto="$pacienteActivo->foto" :nombre="$pacienteActivo->nombre_completo" :size="38"
                          bg="#fff" color="#2e7d52" />
                <div>
                    <div class="fw-semibold">{{ $pacienteActivo->nombre_completo }}</div>
                    <div style="font-size:.75rem;opacity:.8">{{ $conversacion->colaboracion ?? 'Conversación directa' }}</div>
                </div>
            </div>

            <div class="chat-msgs" id="chatMsgs">
                @forelse($mensajes as $msg)
                    @php $esMio = $msg->autor_user_id === Auth::id(); @endphp
                    <div class="d-flex {{ $esMio ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="msg-bubble {{ $esMio ? 'msg-out' : 'msg-in' }}">
                            @if(!$esMio)
                                <span style="font-size:.7rem;color:#2e7d52;font-weight:600;display:block;margin-bottom:.1rem">
                                    {{ $msg->autor?->name ?? $pacienteActivo->nombre_completo }}
                                </span>
                            @endif
                            {{ $msg->contenido }}
                            <span class="msg-time">{{ $msg->enviado_en?->format('d/m H:i') ?? $msg->created_at->format('d/m H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-dots fs-2 d-block mb-2 opacity-25"></i>
                        Sin mensajes aún. ¡Escribe el primero!
                    </div>
                @endforelse
            </div>

            <div class="chat-foot">
                <form method="POST" action="{{ route('mensajes.store') }}" class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="conversacion_id" value="{{ $conversacion->id }}">
                    <input type="hidden" name="paciente_id" value="{{ $pacienteActivo->id }}">
                    <input type="text" name="contenido" class="form-control"
                           placeholder="Escribe un mensaje..." required autocomplete="off" maxlength="2000">
                    <button type="submit" class="btn btn-success px-3">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="chat-empty">
                <i class="bi bi-chat-square-text fs-1 opacity-25 mb-2"></i>
                <div>Selecciona un paciente para empezar a chatear.</div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
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
@endsection
