<?php

namespace Tests\Feature\Relations;

use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacturaPagoRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_factura_has_many_pagos(): void
    {
        $factura = Factura::factory()->create();
        $pagos = Pago::factory()->count(2)->for($factura)->create();

        $this->assertCount(2, $factura->pagos);
        $this->assertTrue($factura->pagos->contains($pagos->first()));
    }

    public function test_pago_belongs_to_factura(): void
    {
        $factura = Factura::factory()->create();
        $pago = Pago::factory()->for($factura)->create();

        $this->assertNotNull($pago->factura);
        $this->assertEquals($factura->id, $pago->factura->id);
    }
}