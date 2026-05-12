@extends('layouts.paciente')
@section('titulo', 'Mi progreso')

@section('contenido')
<h1 class="page-title">Mi progreso</h1>
<p class="text-muted mb-4">Evolución de tus mediciones a lo largo del tiempo.</p>

@if($mediciones->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-graph-up fs-1 text-muted d-block mb-3"></i>
            <h5>Sin mediciones registradas</h5>
            <p class="text-muted">Tu nutricionista registrará tus mediciones tras cada consulta.</p>
        </div>
    </div>
@else
    <div class="row g-3 mb-4">
        @php $ultima = $mediciones->last(); @endphp
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">Peso actual</small>
                <h3 class="text-success-dark mb-0">{{ $ultima->peso_kg }} kg</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">IMC</small>
                <h3 class="text-info mb-0">{{ $ultima->imc ? number_format($ultima->imc, 1) : '—' }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">Altura</small>
                <h3 class="mb-0">{{ $ultima->altura_cm }} cm</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <small class="text-muted">Mediciones</small>
                <h3 class="mb-0">{{ $mediciones->count() }}</h3>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white"><h5 class="mb-0">Evolución del peso</h5></div>
        <div class="card-body">
            <canvas id="graficoPeso" height="80"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white"><h5 class="mb-0">Histórico de mediciones</h5></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Peso (kg)</th>
                            <th>Altura (cm)</th>
                            <th>IMC</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mediciones->sortByDesc('fecha_medicion') as $m)
                            <tr>
                                <td>{{ $m->fecha_medicion->format('d/m/Y') }}</td>
                                <td>{{ $m->peso_kg }}</td>
                                <td>{{ $m->altura_cm }}</td>
                                <td>{{ $m->imc ? number_format($m->imc, 1) : '—' }}</td>
                                <td class="text-muted small">{{ $m->notas ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
@if($mediciones->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('graficoPeso');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($mediciones->map(fn($m) => $m->fecha_medicion->format('d/m'))->values()),
            datasets: [{
                label: 'Peso (kg)',
                data: @json($mediciones->pluck('peso_kg')->values()),
                borderColor: '#2c7a4b',
                backgroundColor: 'rgba(44, 122, 75, .15)',
                tension: .3,
                fill: true,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
@endif
@endsection
