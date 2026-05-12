@extends('layouts.paciente')
@section('titulo', 'Mi día')

@section('contenido')
<h1 class="page-title">Mi día</h1>
<p class="text-muted mb-4">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] Y') }}</p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded p-2">
                    <i class="bi bi-calendar-check fs-3 text-success"></i>
                </div>
                <div>
                    <small class="text-muted">Próxima cita</small>
                    @if($proximaCita)
                        <div class="fw-bold">{{ $proximaCita->inicio->format('d/m H:i') }}</div>
                        <small class="text-muted">{{ $proximaCita->nutricionista->nombre_completo }}</small>
                    @else
                        <div class="fw-bold text-muted">Sin citas</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 rounded p-2">
                    <i class="bi bi-speedometer fs-3 text-info"></i>
                </div>
                <div>
                    <small class="text-muted">Última medición</small>
                    @if($ultimaMedicion)
                        <div class="fw-bold">{{ $ultimaMedicion->peso_kg }} kg @if($ultimaMedicion->imc) · IMC {{ number_format($ultimaMedicion->imc, 1) }} @endif</div>
                        <small class="text-muted">{{ $ultimaMedicion->fecha_medicion->format('d/m/Y') }}</small>
                    @else
                        <div class="fw-bold text-muted">Sin datos</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 rounded p-2">
                    <i class="bi bi-person-badge fs-3 text-warning"></i>
                </div>
                <div>
                    <small class="text-muted">Mi nutricionista</small>
                    <div class="fw-bold">{{ $paciente->nutricionista->nombre_completo }}</div>
                    <small class="text-muted">{{ $paciente->nutricionista->especialidad }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0"><i class="bi bi-cup-hot me-2 text-success"></i>Comidas de hoy</h5>
    </div>
    <div class="card-body">
        @if($itemsHoy->isEmpty())
            <p class="text-muted mb-0 text-center py-4">
                <i class="bi bi-info-circle fs-1 d-block mb-2"></i>
                No hay comidas planificadas para hoy.
                @if(!$plan)
                    Tu nutricionista aún no te ha asignado un plan semanal.
                @endif
            </p>
        @else
            <div class="row g-3">
                @foreach($itemsHoy as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="border rounded p-3 h-100">
                            <span class="badge bg-success-subtle text-success-dark mb-2">{{ ucfirst($item->tipo_comida) }}</span>
                            <h6 class="fw-bold mb-1">{{ $item->receta->nombre ?? '—' }}</h6>
                            @if($item->notas)
                                <small class="text-muted d-block">{{ $item->notas }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="fw-bold"><i class="bi bi-lightbulb text-warning me-1"></i> Consejo del día</h6>
        <p class="text-muted small mb-0">
            Bebe al menos 1,5 litros de agua a lo largo del día. Una correcta hidratación favorece el metabolismo y reduce la sensación de hambre.
        </p>
    </div>
</div>
@endsection
