@extends('layouts.app')
@section('titulo', isset($pago) ? 'Editar pago' : 'Nuevo pago')
@section('contenido')
<h2 class="mb-4"><i class="bi bi-credit-card me-2 text-success"></i>
    {{ isset($pago) ? 'Editar pago' : 'Nuevo pago' }}
</h2>
<div class="card shadow-sm" style="max-width:500px">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ isset($pago) ? route('pagos.update', $pago) : route('pagos.store') }}" method="POST">
            @csrf
            @if(isset($pago)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Factura <span class="text-danger">*</span></label>
                <select name="factura_id" class="form-select @error('factura_id') is-invalid @enderror" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($facturas as $f)
                        <option value="{{ $f->id }}" @selected(old('factura_id', $pago->factura_id ?? '') == $f->id)>
                            {{ $f->numero_factura }}
                        </option>
                    @endforeach
                </select>
                @error('factura_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre del titular <span class="text-danger">*</span></label>
                <input type="text" name="nombre_titular" class="form-control @error('nombre_titular') is-invalid @enderror"
                       value="{{ old('nombre_titular', $pago->nombre_titular ?? '') }}" required>
                @error('nombre_titular')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fecha de pago <span class="text-danger">*</span></label>
                <input type="datetime-local" name="fecha_pago"
                       class="form-control @error('fecha_pago') is-invalid @enderror"
                       value="{{ old('fecha_pago', isset($pago) ? \Carbon\Carbon::parse($pago->fecha_pago)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                @error('fecha_pago')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg me-1"></i>{{ isset($pago) ? 'Guardar cambios' : 'Registrar pago' }}
                </button>
                <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
