@extends('layouts.app')
@section('titulo', 'Conversaciones')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-chat-dots me-2 text-success"></i>Conversaciones</h2>
    <a href="{{ route('conversaciones.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Nueva conversación
    </a>
</div>

<form method="GET" action="{{ route('conversaciones.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por colaboración o resumen…"
               value="{{ request('buscar') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-success"><i class="bi bi-search me-1"></i>Buscar</button>
        <a href="{{ route('conversaciones.index') }}" class="btn btn-outline-secondary ms-1">Limpiar</a>
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
                <th>{!! colLink('creado_en', 'Fecha', $orden, $dir) !!}</th>
                <th>Paciente</th>
                <th>Nutricionista</th>
                <th>{!! colLink('colaboracion', 'Colaboración', $orden, $dir) !!}</th>
                <th>{!! colLink('porcentaje', '% Completado', $orden, $dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($conversaciones as $c)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($c->creado_en)->format('d/m/Y H:i') }}</td>
                    <td>{{ $c->paciente->nombre_completo ?? '—' }}</td>
                    <td>{{ $c->nutricionista->nombre_completo ?? '—' }}</td>
                    <td>{{ Str::limit($c->colaboracion, 40) }}</td>
                    <td>
                        <div class="progress" style="height:18px; min-width:80px">
                            <div class="progress-bar bg-success" style="width:{{ $c->porcentaje }}%">
                                {{ $c->porcentaje }}%
                            </div>
                        </div>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('conversaciones.edit', $c) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('conversaciones.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta conversación?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay conversaciones registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
    <small class="text-muted">{{ $conversaciones->total() }} resultado(s)</small>
    {{ $conversaciones->links() }}
</div>
@endsection
