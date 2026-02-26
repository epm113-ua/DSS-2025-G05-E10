<?php

namespace Tests\Feature\Relations;

use App\Models\OfertaIngrediente;
use App\Models\Tienda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TiendaOfertaIngredienteRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_tienda_has_many_ofertas(): void
    {
        $tienda = Tienda::factory()->create();
        $ofertas = OfertaIngrediente::factory()->count(2)->for($tienda)->create();

        $this->assertCount(2, $tienda->ofertas);
        $this->assertTrue($tienda->ofertas->contains($ofertas->first()));
    }

    public function test_oferta_belongs_to_tienda(): void
    {
        $tienda = Tienda::factory()->create();
        $oferta = OfertaIngrediente::factory()->for($tienda)->create();

        $this->assertNotNull($oferta->tienda);
        $this->assertEquals($tienda->id, $oferta->tienda->id);
    }
}