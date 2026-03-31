@extends('layouts.app')
@section('titulo', isset($mensaje) ? 'Editar mensaje' : 'Nuevo mensaje')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-envelope me-2 text-success"></i>
    {{ isset($mensaje) ? 'Editar mensaje' : 'Nuevo mensaje' }}
</h2>
<div class="card shadow-sm" style="max-width:580px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($mensaje) ? route('mensajes.update', $mensaje) : route('mensajes.store') }}" method="POST">
            @csrf
            @if(isset($mensaje)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Conversación <span class="text-danger">*</span></label>
                <select name="conversacion_id" class="form-select @error('conversacion_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($conversaciones as $c)
                        <option value="{{ $c->id }}" @selected(old('conversacion_id', $mensaje->conversacion_id ?? '') == $c->id)>
                            #{{ $c->id }} – {{ $c->paciente->nombre_completo ?? '' }} ({{ \Carbon\Carbon::parse($c->creado_en)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('conversacion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Factura asociada (opcional)</label>
                <select name="factura_id" class="form-select @error('factura_id') is-invalid @enderror">
                    <option value="">— Sin factura —</option>
                    @foreach($facturas as $f)
                        <option value="{{ $f->id }}" @selected(old('factura_id', $mensaje->factura_id ?? '') == $f->id)>
                            {{ $f->numero_factura }}
                        </option>
                    @endforeach
                </select>
                @error('factura_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Contenido <span class="text-danger">*</span></label>
                <textarea name="contenido" rows="4" class="form-control @error('contenido') is-invalid @enderror"
                          required>{{ old('contenido', $mensaje->contenido ?? '') }}</textarea>
                @error('contenido')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fecha de envío <span class="text-danger">*</span></label>
                <input type="datetime-local" name="enviado_en"
                       class="form-control @error('enviado_en') is-invalid @enderror"
                       value="{{ old('enviado_en', isset($mensaje) ? \Carbon\Carbon::parse($mensaje->enviado_en)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                @error('enviado_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($mensaje) ? 'Guardar cambios' : 'Enviar' }}
                </button>
                <a href="{{ route('mensajes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
