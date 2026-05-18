@extends('layouts.app')
@section('titulo','Panel de Administración')
@section('breadcrumb','Administración')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-shield-check me-2 text-success"></i>Panel de Administración</h4>
    <a href="{{ route('admin.usuarios.crear') }}" class="btn btn-success btn-sm">
        <i class="bi bi-person-plus me-1"></i>Nuevo usuario
    </a>
</div>

<div class="row g-3 mb-4">
    @foreach([
        ['bi-person-badge','primary',  'Nutricionistas',      $resumen['nutricionistas'],      route('nutricionistas.index')],
        ['bi-people',      'success',  'Pacientes',            $resumen['pacientes'],           route('pacientes.index')],
        ['bi-person-circle','info',    'Usuarios totales',     $resumen['usuarios'],            route('admin.usuarios')],
        ['bi-calendar-clock','warning','Citas pendientes',     $resumen['citas_pendientes'],    route('citas.index')],
        ['bi-calendar-check','success','Citas completadas',    $resumen['citas_completadas'],   route('citas.index')],
        ['bi-book',        'secondary','Recetas',              $resumen['recetas'],             route('recetas.index')],
        ['bi-receipt',     'danger',   'Facturas pendientes',  $resumen['facturas_pendientes'], route('facturas.index')],
        ['bi-check-circle','success',  'Facturas pagadas',     $resumen['facturas_pagadas'],    route('facturas.index')],
        ['bi-credit-card', 'dark',     'Pagos registrados',    $resumen['pagos'],               route('pagos.index')],
        ['bi-shop',        'primary',  'Tiendas',              $resumen['tiendas'],             route('tiendas.index')],
    ] as [$icon,$color,$label,$valor,$href])
    <div class="col-6 col-lg-3 col-xl-2">
        <a href="{{ $href }}" class="text-decoration-none">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-2 p-3">
                    <div class="rounded-circle bg-{{ $color }} bg-opacity-10 p-2 flex-shrink-0">
                        <i class="bi {{ $icon }} text-{{ $color }} fs-6"></i>
                    </div>
                    <div>
                        <div class="fs-5 fw-bold text-dark lh-1">{{ $valor }}</div>
                        <div class="text-muted" style="font-size:.71rem">{{ $label }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-people fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Gestión de usuarios</h6>
            <p class="text-muted small mb-2">Crea y gestiona roles y accesos.</p>
            <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-success btn-sm mt-auto">Ver usuarios</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-person-badge fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Nutricionistas</h6>
            <p class="text-muted small mb-2">Gestiona el equipo de profesionales.</p>
            <a href="{{ route('nutricionistas.index') }}" class="btn btn-outline-success btn-sm mt-auto">Ver nutricionistas</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-receipt fs-2 text-success mb-2"></i>
            <h6 class="fw-bold">Facturación</h6>
            <p class="text-muted small mb-2">Revisa el estado de facturas y pagos.</p>
            <a href="{{ route('facturas.index') }}" class="btn btn-outline-success btn-sm mt-auto">Ver facturas</a>
        </div>
    </div>
</div>
@endsection
