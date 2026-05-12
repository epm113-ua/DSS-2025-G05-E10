@extends('layouts.app')
@section('titulo', 'Detalle de plan semanal')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="page-title">Plan semanal</h1>
        <p class="text-muted mb-0">
            Semana del {{ \Carbon\Carbon::parse($planSemanal->semana_inicio)->locale('es')->isoFormat('D [de] MMMM Y') }}
        </p>
    </div>
    <a href="{{ route('plan-semanales.index') }}" class="btn btn-outline-success">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">Paciente</small>
                <h5 class="mb-0">{{ $planSemanal->cita->paciente->nombre_completo ?? '—' }}</h5>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Nutricionista</small>
                <h5 class="mb-0">{{ $planSemanal->cita->nutricionista->nombre_completo ?? '—' }}</h5>
            </div>
        </div>
        @if($planSemanal->notas)
            <hr>
            <small class="text-muted">{{ $planSemanal->notas }}</small>
        @endif
    </div>
</div>

@php
    $diasSemana = [1=>'Lunes', 2=>'Martes', 3=>'Miércoles', 4=>'Jueves', 5=>'Viernes', 6=>'Sábado', 7=>'Domingo'];
    $itemsPorDia = $planSemanal->itemPlans->groupBy('dia_semana');
@endphp

<div class="row g-3">
    @foreach($diasSemana as $num => $nombre)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100">
                <div class="card-header bg-success bg-opacity-10 border-bottom">
                    <strong class="text-success-dark">{{ $nombre }}</strong>
                </div>
                <div class="card-body p-3">
                    @php $itemsDia = $itemsPorDia->get($num, collect())->sortBy('tipo_comida'); @endphp
                    @forelse($itemsDia as $item)
                        <div class="border-start border-3 border-success ps-2 mb-3">
                            <span class="badge bg-secondary-subtle text-secondary small">{{ ucfirst($item->tipo_comida) }}</span>
                            <div class="fw-bold small mt-1">{{ $item->receta->nombre ?? '—' }}</div>
                            @if($item->notas)
                                <div class="text-muted" style="font-size: .75rem">{{ $item->notas }}</div>
                            @endif
                        </div>
                    @empty
                        <small class="text-muted">Sin comidas</small>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
