@extends('layouts.app')
@section('title', 'Inicio')
@section('breadcrumb', 'Inicio')

@section('contenido')
{{-- Redirige automáticamente al dashboard; esta vista es fallback --}}
<div class="text-center py-5">
    <p class="text-muted">Redirigiendo...</p>
</div>
@endsection
