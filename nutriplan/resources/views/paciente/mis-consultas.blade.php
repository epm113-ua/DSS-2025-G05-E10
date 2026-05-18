@extends('layouts.paciente')
@section('title','Mis Consultas')
@section('breadcrumb','Mis Consultas')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Mis Consultas</h4>
        <small class="text-muted">Con {{ $paciente->nutricionista?->nombre_completo }}</small>
    </div>
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalSolicitar">
        <i class="bi bi-plus-circle me-1"></i>Solicitar cita
    </button>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-success">
                <tr><th>Fecha</th><th>Hora</th><th>Nutricionista</th><th>Motivo</th><th>Estado</th></tr>
            </thead>
            <tbody>
                @forelse($citas as $cita)
                <tr>
                    <td>{{ $cita->inicio->format('d/m/Y') }}</td>
                    <td>{{ $cita->inicio->format('H:i') }}</td>
                    <td>{{ $cita->nutricionista?->nombre_completo ?? '—' }}</td>
                    <td class="text-muted small">{{ $cita->motivo }}</td>
                    <td>
                        @php $badges=['pendiente'=>'warning','completada'=>'success','cancelada'=>'secondary']; @endphp
                        <span class="badge bg-{{ $badges[$cita->estado] ?? 'secondary' }} text-capitalize">{{ $cita->estado }}</span>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No tienes consultas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $citas->links() }}

<div class="modal fade" id="modalSolicitar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Solicitar nueva cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('paciente.solicitar-cita') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Fecha y hora deseada</label>
                        <input type="datetime-local" name="inicio" class="form-control" required
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Motivo (opcional)</label>
                        <textarea name="motivo" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Solicitar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
