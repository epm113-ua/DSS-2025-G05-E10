<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\Mensaje;
use App\Models\Paciente;
use App\Models\Pago;

class FacturacionService
{
    public function generarFactura(Paciente $paciente): Factura
    {
        $numero = 'F-' . now()->format('Ymd') . '-' . str_pad((string) (Factura::count() + 1), 4, '0', STR_PAD_LEFT);

        return Factura::create([
            'paciente_id'    => $paciente->id,
            'numero_factura' => $numero,
            'pagado_en'      => null,
        ]);
    }

    public function registrarPago(Factura $factura, string $nombreTitular, ?Mensaje $mensaje = null): Pago
    {
        if ($factura->pagado_en !== null) {
            throw new \RuntimeException("La factura [{$factura->numero_factura}] ya ha sido pagada.");
        }

        $pago = Pago::create([
            'factura_id' => $factura->id,
            'nombre_titular' => $nombreTitular,
            'fecha_pago' => now(),
        ]);

        $factura->update(['pagado_en' => now()]);

        if ($mensaje !== null) {
            $mensaje->update(['factura_id' => $factura->id]);
        }

        return $pago;
    }

    public function facturasPendientes(Paciente $paciente)
    {
        return $paciente->facturas()
            ->whereNull('pagado_en')
            ->with('pagos')
            ->orderBy('created_at')
            ->get();
    }
}
