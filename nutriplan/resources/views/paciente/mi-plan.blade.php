@extends('layouts.paciente')
@section('titulo', 'Mi plan semanal')

@section('contenido')
<h1 class="page-title">Mi plan semanal</h1>
<p class="text-muted mb-4">Plan completo de la semana asignado por tu nutricionista.</p>

@if(!$plan)
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
            <h5>Aún no tienes plan asignado</h5>
            <p class="text-muted">Tu nutricionista te asignará un plan semanal tras tu próxima consulta.</p>
        </div>
    </div>
@else
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <div>
                    <small class="text-muted">Semana de</small>
                    <h5 class="mb-0">{{ \Carbon\Carbon::parse($plan->semana_inicio)->locale('es')->isoFormat('D [de] MMMM Y') }}</h5>
                </div>
                <div class="text-end">
                    <small class="text-muted">Asignado por</small>
                    <h6 class="mb-0">{{ $plan->cita->nutricionista->nombre_completo ?? '—' }}</h6>
                </div>
            </div>
            @if($plan->notas)
                <hr>
                <small class="text-muted">{{ $plan->notas }}</small>
            @endif
        </div>
    </div>

    @php
        $diasSemana = [1=>'Lunes', 2=>'Martes', 3=>'Miércoles', 4=>'Jueves', 5=>'Viernes', 6=>'Sábado', 7=>'Domingo'];
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
                            <small class="text-muted">Sin comidas planificadas</small>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
