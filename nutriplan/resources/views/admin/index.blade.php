@extends('layouts.app')
@section('titulo', 'Panel de Administración')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2 text-warning"></i>Panel de Administración</h2>
        <p class="text-muted mb-0">Sesión como <strong>{{ $usuario->name }}</strong>
            <span class="badge bg-warning text-dark ms-1"><i class="bi bi-star-fill me-1"></i>Admin</span>
        </p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Volver al Dashboard
    </a>
</div>

<div class="row g-3 mb-4">
    @php
        $tarjetas = [
            ['label'=>'Nutricionistas',     'valor'=>$resumen['nutricionistas'],      'icono'=>'person-badge',    'color'=>'success'],
            ['label'=>'Pacientes',          'valor'=>$resumen['pacientes'],           'icono'=>'people',          'color'=>'primary'],
            ['label'=>'Citas pendientes',   'valor'=>$resumen['citas_pendientes'],    'icono'=>'clock-history',   'color'=>'warning'],
            ['label'=>'Citas completadas',  'valor'=>$resumen['citas_completadas'],   'icono'=>'calendar-check',  'color'=>'success'],
            ['label'=>'Recetas',            'valor'=>$resumen['recetas'],             'icono'=>'journal-richtext','color'=>'info'],
            ['label'=>'Tiendas',            'valor'=>$resumen['tiendas'],             'icono'=>'shop',            'color'=>'secondary'],
            ['label'=>'Ingredientes',       'valor'=>$resumen['ingredientes'],        'icono'=>'basket',          'color'=>'secondary'],
            ['label'=>'Facturas pendientes','valor'=>$resumen['facturas_pendientes'], 'icono'=>'receipt',         'color'=>'danger'],
            ['label'=>'Facturas pagadas',   'valor'=>$resumen['facturas_pagadas'],    'icono'=>'check-circle',    'color'=>'success'],
            ['label'=>'Pagos registrados',  'valor'=>$resumen['pagos'],              'icono'=>'credit-card',     'color'=>'primary'],
        ];
    @endphp
    @foreach($tarjetas as $t)
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="card-body p-2">
                <i class="bi bi-{{ $t['icono'] }} fs-2 text-{{ $t['color'] }}"></i>
                <div class="fs-2 fw-bold mt-1">{{ $t['valor'] }}</div>
                <div class="text-muted" style="font-size:.8rem">{{ $t['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-grid me-2 text-warning"></i>Gestión del sistema
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('nutricionistas.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-badge me-2 text-success"></i>Nutricionistas</span>
                        <span class="badge bg-success rounded-pill">{{ $resumen['nutricionistas'] }}</span>
                    </a>
                    <a href="{{ route('pacientes.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-people me-2 text-primary"></i>Pacientes</span>
                        <span class="badge bg-primary rounded-pill">{{ $resumen['pacientes'] }}</span>
                    </a>
                    <a href="{{ route('citas.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar-check me-2 text-warning"></i>Citas</span>
                        <span class="badge bg-warning text-dark rounded-pill">{{ $resumen['citas_pendientes'] + $resumen['citas_completadas'] }}</span>
                    </a>
                    <a href="{{ route('recetas.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-journal-richtext me-2 text-info"></i>Recetas</span>
                        <span class="badge bg-info text-dark rounded-pill">{{ $resumen['recetas'] }}</span>
                    </a>
                    <a href="{{ route('tiendas.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-shop me-2 text-secondary"></i>Tiendas</span>
                        <span class="badge bg-secondary rounded-pill">{{ $resumen['tiendas'] }}</span>
                    </a>
                    <a href="{{ route('facturas.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-receipt me-2 text-danger"></i>Facturas pendientes</span>
                        <span class="badge bg-danger rounded-pill">{{ $resumen['facturas_pendientes'] }}</span>
                    </a>
                    <a href="{{ route('admin.usuarios') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-gear me-2 text-dark"></i>Gestionar usuarios</span>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-bar-chart me-2 text-success"></i>Nutricionistas con más pacientes
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Nombre</th><th>Especialidad</th><th>Pacientes</th><th>Valoración</th></tr>
                    </thead>
                    <tbody>
                    @forelse($nutricionistasTop as $i => $n)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td>{{ $n->nombre_completo }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $n->especialidad }}</span></td>
                            <td><span class="badge bg-primary">{{ $n->pacientes_count }}</span></td>
                            <td><small class="text-warning">★</small> {{ number_format($n->valoracion_media, 1) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Sin datos.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-clock-history me-2 text-warning"></i>Últimas citas
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 small">
                    <thead class="table-light">
                        <tr><th>Fecha</th><th>Paciente</th><th>Nutricionista</th><th>Estado</th></tr>
                    </thead>
                    <tbody>
                    @php $b=['pendiente'=>'warning','completada'=>'success','cancelada'=>'danger']; @endphp
                    @forelse($citasRecientes as $c)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($c->inicio)->format('d/m/Y') }}</td>
                            <td>{{ $c->paciente->nombre_completo ?? '—' }}</td>
                            <td>{{ $c->nutricionista->nombre_completo ?? '—' }}</td>
                            <td><span class="badge bg-{{ $b[$c->estado] ?? 'secondary' }}">{{ ucfirst($c->estado) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Sin citas.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
