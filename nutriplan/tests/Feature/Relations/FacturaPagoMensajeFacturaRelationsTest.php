<?php

namespace Tests\Feature\Relations;

use App\Models\Factura;
use App\Models\Mensaje;
use App\Models\Pago;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacturaPagoMensajeFacturaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_factura_has_many_pagos_and_pago_belongs_to_factura(): void
    {
        $factura = Factura::factory()->create();
        $pagos = Pago::factory()->count(2)->for($factura)->create();

        $this->assertCount(2, $factura->pagos);
        $this->assertTrue($factura->pagos->contains($pagos->first()));
        $this->assertEquals($factura->id, $pagos->first()->factura->id);
    }

    public function test_mensaje_can_belong_to_factura_nullable_and_factura_has_many_mensajes(): void
    {
        $factura = Factura::factory()->create();

        // Mensaje con factura
        $msgConFactura = Mensaje::factory()->conFactura()->create([
            'factura_id' => $factura->id,
        ]);

        // Mensaje sin factura
        $msgSinFactura = Mensaje::factory()->create([
            'factura_id' => null,
        ]);

        $this->assertEquals($factura->id, $msgConFactura->factura->id);
        $this->assertNull($msgSinFactura->factura);

        $this->assertTrue($factura->mensajes->contains($msgConFactura));
    }
}