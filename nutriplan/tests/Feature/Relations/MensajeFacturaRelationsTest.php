<?php

namespace Tests\Feature\Relations;

use App\Models\Factura;
use App\Models\Mensaje;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MensajeFacturaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_factura_has_many_mensajes(): void
    {
        $factura = Factura::factory()->create();
        $msg = Mensaje::factory()->conFactura()->create(['factura_id' => $factura->id]);

        $this->assertTrue($factura->mensajes->contains($msg));
    }

    public function test_mensaje_belongs_to_factura_nullable(): void
    {
        $factura = Factura::factory()->create();

        $msgConFactura = Mensaje::factory()->conFactura()->create(['factura_id' => $factura->id]);
        $msgSinFactura = Mensaje::factory()->create(['factura_id' => null]);

        $this->assertNotNull($msgConFactura->factura);
        $this->assertEquals($factura->id, $msgConFactura->factura->id);
        $this->assertNull($msgSinFactura->factura);
    }
}
