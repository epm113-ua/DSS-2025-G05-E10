@extends('layouts.app')
@section('titulo', 'Mediciones')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-activity me-2 text-success"></i>Mediciones</h2>
    <a href="{{ route('mediciones.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva medición
    </a>
</div>

<form method="GET" action="{{ route('mediciones.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre del paciente…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('mediciones.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
    </div>
    <input type="hidden" name="orden" value="{{ $orden }}">
    <input type="hidden" name="dir"   value="{{ $dir }}">
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-success">
            <tr>
                @php
                    function colLink($campo, $label, $orden, $dir) {
                        $nextDir = ($orden === $campo && $dir === 'asc') ? 'desc' : 'asc';
                        $icon = $orden === $campo ? ($dir === 'asc' ? '↑' : '↓') : '';
                        $url = request()->fullUrlWithQuery(['orden' => $campo, 'dir' => $nextDir]);
                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
                    }
                @endphp
                <th>Paciente</th>
                <th>{!! colLink('fecha_medicion', 'Fecha', $orden, $dir) !!}</th>
                <th>{!! colLink('peso_kg', 'Peso (kg)', $orden, $dir) !!}</th>
                <th>{!! colLink('altura_cm', 'Altura (cm)', $orden, $dir) !!}</th>
                <th>IMC</th>
                <th>{!! colLink('porcentaje_grasa', '% Grasa', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($mediciones as $m)
                @php
                    $alturaM = $m->altura_cm / 100;
                    $imc     = $alturaM > 0 ? round($m->peso_kg / ($alturaM * $alturaM), 1) : '—';
                @endphp
                <tr>
                    <td>{{ $m->paciente->nombre_completo ?? '—' }}</td>
                    <td>{{ $m->fecha_medicion }}</td>
                    <td>{{ $m->peso_kg }}</td>
                    <td>{{ $m->altura_cm }}</td>
                    <td><span class="badge bg-info text-dark">{{ $imc }}</span></td>
                    <td>{{ $m->porcentaje_grasa !== null ? $m->porcentaje_grasa . ' %' : '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('mediciones.edit', $m) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('mediciones.destroy', $m) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta medición?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay mediciones registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $mediciones->links() }}
</div>
@endsection
