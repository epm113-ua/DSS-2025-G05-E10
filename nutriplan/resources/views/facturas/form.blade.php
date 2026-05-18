@extends('layouts.app')
@section('titulo', isset($factura) ? 'Editar factura' : 'Nueva factura')
@section('breadcrumb', isset($factura) ? 'Facturas › Editar' : 'Facturas › Nueva')
@section('contenido')
<h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2 text-success"></i>{{ isset($factura) ? 'Editar factura' : 'Nueva factura' }}</h4>
<div class="card" style="max-width:560px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ isset($factura) ? route('facturas.update',$factura) : route('facturas.store') }}" method="POST">
            @csrf
            @if(isset($factura))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold small">Paciente <span class="text-danger">*</span></label>
                <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required>
                    <option value="">— Seleccionar —</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(old('paciente_id', $factura->paciente_id ?? '') == $p->id)>{{ $p->nombre_completo }}</option>
                    @endforeach
                </select>
                @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Número de factura</label>
                <input type="text" name="numero_factura" class="form-control @error('numero_factura') is-invalid @enderror"
                       value="{{ old('numero_factura', $factura->numero_factura ?? '') }}"
                       placeholder="Se genera automáticamente si lo dejas vacío">
                @error('numero_factura')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Importe (€) <span class="text-danger">*</span></label>
                <input type="number" name="importe" step="0.01" min="0"
                       class="form-control @error('importe') is-invalid @enderror"
                       value="{{ old('importe', $factura->importe ?? '') }}" required>
                @error('importe')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">Fecha de pago (vacío = pendiente)</label>
                <input type="datetime-local" name="pagado_en"
                       class="form-control @error('pagado_en') is-invalid @enderror"
                       value="{{ old('pagado_en', isset($factura) && $factura->pagado_en ? $factura->pagado_en->format('Y-m-d\TH:i') : '') }}">
                @error('pagado_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>{{ isset($factura) ? 'Guardar cambios' : 'Crear factura' }}</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
