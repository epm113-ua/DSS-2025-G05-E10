@extends('layouts.app')
@section('titulo', 'Conversaciones')
@section('breadcrumb', 'Conversaciones')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-chat-dots me-2 text-success"></i>Conversaciones</h4>
    <a href="{{ route('conversaciones.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nueva conversación
    </a>
</div>

<form method="GET" action="{{ route('conversaciones.index') }}" class="card mb-4">
    <div class="card-body py-2">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control form-control-sm"
                       placeholder="Buscar por colaboración o paciente…" value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <select name="paciente_id" class="form-select form-select-sm">
                    <option value="">Todos los pacientes</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(request('paciente_id') == $p->id)>{{ $p->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-search me-1"></i>Buscar</button>
                <a href="{{ route('conversaciones.index') }}" class="btn btn-outline-secondary btn-sm ms-1">Limpiar</a>
            </div>
        </div>
        <input type="hidden" name="orden" value="{{ $orden }}">
        <input type="hidden" name="dir"   value="{{ $dir }}">
    </div>
</form>

<div class="card">
    <div class="table-responsive">
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
                <th>{!! colLink('creado_en','Fecha',$orden,$dir) !!}</th>
                <th>Paciente</th>
                <th>Nutricionista</th>
                <th>{!! colLink('colaboracion','Colaboración',$orden,$dir) !!}</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($conversaciones as $c)
                <tr>
                    <td class="text-muted small">{{ $c->creado_en?->format('d/m/Y H:i') ?? $c->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($c->paciente?->foto)
                                <img src="{{ asset('storage/'.$c->paciente->foto) }}" class="rounded-circle" style="width:26px;height:26px;object-fit:cover">
                            @else
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                     style="width:26px;height:26px;font-size:.6rem">
                                    {{ strtoupper(substr($c->paciente?->nombre_completo ?? '?',0,1)) }}{{ strtoupper(substr(strstr($c->paciente?->nombre_completo ?? '',  ' '),1,1)) }}
                                </div>
                            @endif
                            <span class="small">{{ $c->paciente?->nombre_completo ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $c->nutricionista?->nombre_completo ?? '—' }}</td>
                    <td class="small">{{ Str::limit($c->colaboracion, 40) }}</td>
                    <td class="text-end">
                        <a href="{{ route('conversaciones.show', $c) }}" class="btn btn-sm btn-outline-success me-1" title="Ver chat">
                            <i class="bi bi-chat-text"></i>
                        </a>
                        <a href="{{ route('conversaciones.edit', $c) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('conversaciones.destroy', $c) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta conversación y todos sus mensajes?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay conversaciones registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $conversaciones->links() }}</div>
@endsection
