@extends('layouts.paciente')
@section('title','Mi Día')
@section('breadcrumb','Mi Día')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">¡Buenos días, {{ Auth::user()->name }}!</h4>
        <p class="text-muted small mb-0">{{ now()->isoFormat('dddd, D [de] MMMM') }}</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        @if($paciente->nutricionista?->foto)
            <img src="{{ asset('storage/'.$paciente->nutricionista->foto) }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover">
        @else
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-size:.75rem;font-weight:700">
                {{ strtoupper(substr($paciente->nutricionista?->nombre_completo ?? 'N',0,2)) }}
            </div>
        @endif
        <span class="text-muted small d-none d-md-inline">{{ $paciente->nutricionista?->nombre_completo }}</span>
    </div>
</div>

<div class="row g-4">
    {{-- Comidas de hoy --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-sun me-1"></i>Comidas de hoy</div>
            <div class="card-body">
                @forelse($itemsHoy as $item)
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 flex-shrink-0">
                            <i class="bi bi-egg-fried text-success"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small">{{ $item->tipo_comida }}</div>
                            <div class="text-muted small">{{ $item->receta?->nombre ?? '—' }}</div>
                            @if($item->receta)
                                <div class="text-muted" style="font-size:.72rem">{{ $item->receta->calorias_kcal }} kcal</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">No hay comidas planificadas para hoy.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Info lateral --}}
    <div class="col-lg-5 d-flex flex-column gap-3">
        {{-- Próxima cita --}}
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-calendar-check me-1"></i>Próxima cita</div>
            <div class="card-body text-center">
                @if($proximaCita)
                    <div class="fw-bold fs-5">{{ $proximaCita->inicio->format('d/m/Y') }}</div>
                    <div class="text-muted small">{{ $proximaCita->inicio->format('H:i') }}</div>
                    <div class="text-muted small mt-1">{{ $proximaCita->motivo }}</div>
                @else
                    <p class="text-muted small mb-0">No hay citas próximas.</p>
                @endif
            </div>
        </div>

        {{-- Último peso --}}
        @if($ultimaMedicion)
        <div class="card">
            <div class="card-header bg-success text-white fw-semibold"><i class="bi bi-activity me-1"></i>Última medición</div>
            <div class="card-body">
                <div class="row text-center g-2">
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-success">{{ $ultimaMedicion->peso_kg }} kg</div>
                        <div class="text-muted" style="font-size:.72rem">Peso</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5">{{ $ultimaMedicion->imc }}</div>
                        <div class="text-muted" style="font-size:.72rem">IMC</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5">{{ $ultimaMedicion->porcentaje_grasa }}%</div>
                        <div class="text-muted" style="font-size:.72rem">Grasa</div>
                    </div>
                </div>
                <div class="text-muted text-center small mt-2">{{ $ultimaMedicion->fecha_medicion->format('d/m/Y') }}</div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
