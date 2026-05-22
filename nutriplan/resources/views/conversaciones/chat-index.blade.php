@extends('layouts.app')
@section('titulo','Mensajes')
@section('styles')
<style>
    .chat-outer  { display:flex; height:calc(100vh - 120px); min-height:450px; background:#fff; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,.08); overflow:hidden; }
    .chat-side   { width:250px; flex-shrink:0; border-right:1px solid #e2e8f0; display:flex; flex-direction:column; }
    .chat-side-hdr { padding:.8rem 1rem; font-size:.8rem; font-weight:700; color:#2e7d52; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid #e2e8f0; flex-shrink:0; }
    .chat-side-list{ flex:1; overflow-y:auto; }
    .chat-side-item{ display:flex; align-items:center; gap:.55rem; padding:.7rem .9rem; text-decoration:none; color:#374151; border-bottom:1px solid #f5f5f5; font-size:.83rem; transition:background .12s; }
    .chat-side-item:hover { background:#f0f9f4; color:#2e7d52; }
    .chat-side-avatar { width:34px; height:34px; border-radius:50%; flex-shrink:0; object-fit:cover; }
    .chat-side-initials { width:34px; height:34px; border-radius:50%; background:#2e7d52; color:#fff; font-size:.68rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .search-box  { padding:.5rem; border-bottom:1px solid #f0f0f0; flex-shrink:0; }
    .search-box input { font-size:.8rem; }
    .chat-main   { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f8f9fa; }
</style>
@endsection
@section('contenido')
<div class="chat-outer">
    <div class="chat-side">
        <div class="chat-side-hdr">Chats</div>
        <div class="search-box">
            <input type="text" class="form-control form-control-sm" id="buscarChat" placeholder="Buscar paciente...">
        </div>
        <div class="chat-side-list" id="chatList">
            @forelse($conversaciones as $c)
            @php
                $pac = $c->paciente;
                $initials = $pac
                    ? strtoupper(substr($pac->nombre_completo,0,1)).strtoupper(substr(strstr($pac->nombre_completo,' '),1,1))
                    : '?';
            @endphp
            <a href="{{ route('conversaciones.show',$c) }}"
               class="chat-side-item"
               data-nombre="{{ strtolower($pac->nombre_completo ?? '') }}">
                @if($pac && $pac->foto)
                    <img src="{{ asset('storage/'.$pac->foto) }}" class="chat-side-avatar" alt="foto">
                @else
                    <div class="chat-side-initials">{{ $initials }}</div>
                @endif
                <div>
                    <div>{{ $pac->nombre_completo ?? 'Paciente' }}</div>
                    <span style="font-size:.7rem;color:#94a3b8;display:block;margin-top:.1rem">{{ $c->updated_at->diffForHumans() }}</span>
                </div>
            </a>
            @empty
            <div class="text-muted small p-3">Sin conversaciones.</div>
            @endforelse
        </div>
    </div>

    <div class="chat-main">
        <i class="bi bi-chat-dots fs-1 text-success opacity-25 d-block mb-3"></i>
        <p class="text-muted fw-semibold">Selecciona una conversación</p>
        <p class="text-muted small">o crea una nueva desde el botón de abajo</p>
        <a href="{{ route('conversaciones.create') }}" class="btn btn-success btn-sm mt-2">
            <i class="bi bi-plus-lg me-1"></i> Nueva conversación
        </a>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.getElementById('buscarChat').addEventListener('input', function(){
        const q = this.value.toLowerCase();
        document.querySelectorAll('.chat-side-item[data-nombre]').forEach(el => {
            el.style.display = el.dataset.nombre.includes(q) ? '' : 'none';
        });
    });
</script>
@endsection
