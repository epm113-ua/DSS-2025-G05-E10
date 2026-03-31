@extends('layouts.app')
@section('titulo', isset($factura) ? 'Editar factura' : 'Nueva factura')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-receipt me-2 text-success"></i>
    {{ isset($factura) ? 'Editar factura' : 'Nueva factura' }}
</h2>
<div class="card shadow-sm" style="max-width:520px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($factura) ? route('facturas.update', $factura) : route('facturas.store') }}" method="POST">
            @csrf
            @if(isset($factura)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Paciente <span class="text-danger">*</span></label>
                <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(old('paciente_id', $factura->paciente_id ?? '') == $p->id)>
                            {{ $p->nombre_completo }}
                        </option>
                    @endforeach
                </select>
                @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Número de factura <span class="text-danger">*</span></label>
                <input type="text" name="numero_factura" class="form-control @error('numero_factura') is-invalid @enderror"
                       value="{{ old('numero_factura', $factura->numero_factura ?? '') }}" required>
                @error('numero_factura')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Pagado el (dejar vacío si está pendiente)</label>
                <input type="datetime-local" name="pagado_en"
                       class="form-control @error('pagado_en') is-invalid @enderror"
                       value="{{ old('pagado_en', isset($factura) && $factura->pagado_en ? \Carbon\Carbon::parse($factura->pagado_en)->format('Y-m-d\TH:i') : '') }}">
                @error('pagado_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($factura) ? 'Guardar cambios' : 'Crear' }}
                </button>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
