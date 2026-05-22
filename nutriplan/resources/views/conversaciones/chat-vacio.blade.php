@extends('layouts.app')
@section('titulo','Mensajes')
@section('styles')
<style>
    .chat-outer { display:flex; height:calc(100vh - 120px); min-height:450px; background:#fff; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,.08); overflow:hidden; }
    .chat-side  { width:220px; flex-shrink:0; border-right:1px solid #e2e8f0; display:flex; flex-direction:column; }
    .chat-side-hdr { padding:.8rem 1rem; font-size:.8rem; font-weight:700; color:#2e7d52; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid #e2e8f0; }
    .chat-main  { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f8f9fa; }
</style>
@endsection
@section('contenido')
<div class="chat-outer">
    <div class="chat-side">
        <div class="chat-side-hdr">Chats</div>
        <div class="p-3 text-muted small">Sin conversaciones.</div>
    </div>
    <div class="chat-main">
        <i class="bi bi-chat-dots fs-1 text-success opacity-25 d-block mb-3"></i>
        <p class="text-muted fw-semibold">No tienes conversaciones activas.</p>
        <a href="{{ route('conversaciones.create') }}" class="btn btn-success btn-sm mt-2">
            <i class="bi bi-plus-lg me-1"></i> Nueva conversación
        </a>
    </div>
</div>
@endsection
