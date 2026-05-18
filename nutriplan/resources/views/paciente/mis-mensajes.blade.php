@extends('layouts.paciente')
@section('title','Mensajes')
@section('breadcrumb','Mensajes')
@section('styles')
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
@endsection
@section('contenido')
<h4 class="fw-bold mb-4">Mensajes con mi nutricionista</h4>

@if($conversacion)
<div class="chat-wrap">
    <div class="chat-hdr">
        <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
             style="width:38px;height:38px;font-size:.8rem">
            {{ strtoupper(substr($paciente->nutricionista?->nombre_completo ?? 'N',0,2)) }}
        </div>
        <div>
            <div class="fw-semibold">{{ $paciente->nutricionista?->nombre_completo }}</div>
            <div style="font-size:.75rem;opacity:.8">{{ $conversacion->colaboracion ?? 'Conversación directa' }}</div>
        </div>
    </div>
    <div class="chat-msgs" id="chatMsgs">
        @forelse($mensajes as $msg)
            @php $esMio = $msg->autor_user_id === Auth::id(); @endphp
            <div class="d-flex {{ $esMio ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="msg-bubble {{ $esMio ? 'msg-out' : 'msg-in' }}">
                    @if(!$esMio)
                        <span style="font-size:.72rem;color:#2e7d52;font-weight:600;display:block;margin-bottom:.1rem">
                            {{ $msg->autor?->name ?? $paciente->nutricionista?->nombre_completo }}
                        </span>
                    @endif
                    {{ $msg->contenido }}
                    <span class="msg-time">{{ $msg->enviado_en?->format('H:i') ?? $msg->created_at->format('H:i') }}</span>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-chat-dots fs-2 d-block mb-2 opacity-25"></i>
                Aún no hay mensajes. ¡Escribe el primero!
            </div>
        @endforelse
    </div>
    <div class="chat-foot">
        {{-- Usa la ruta del panel paciente, no mensajes.store --}}
        <form method="POST" action="{{ route('paciente.enviar-mensaje') }}" class="d-flex gap-2">
            @csrf
            <input type="hidden" name="conversacion_id" value="{{ $conversacion->id }}">
            <input type="text" name="contenido" class="form-control"
                   placeholder="Escribe un mensaje..." required autocomplete="off">
            <button type="submit" class="btn btn-success px-3">
                <i class="bi bi-send-fill"></i>
            </button>
        </form>
    </div>
</div>
@else
<div class="card text-center py-5">
    <div class="card-body">
        <i class="bi bi-chat-dots fs-1 text-success opacity-50 d-block mb-3"></i>
        <h5 class="fw-bold">Aún no tienes conversación activa</h5>
        <p class="text-muted">Tu nutricionista abrirá un canal de comunicación contigo en breve.</p>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>const m=document.getElementById('chatMsgs');if(m)m.scrollTop=m.scrollHeight;</script>
@endsection
