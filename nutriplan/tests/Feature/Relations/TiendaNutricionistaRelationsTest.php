<?php

namespace Tests\Feature\Relations;

use App\Models\Nutricionista;
use App\Models\Tienda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TiendaNutricionistaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_tienda_has_many_nutricionistas(): void
    {
        $tienda = Tienda::factory()->create();
        $nutricionistas = Nutricionista::factory()->count(2)->for($tienda)->create();

        $this->assertCount(2, $tienda->nutricionistas);
        $this->assertTrue($tienda->nutricionistas->contains($nutricionistas->first()));
    }

    public function test_nutricionista_belongs_to_tienda(): void
    {
        $tienda = Tienda::factory()->create();
        $nutricionista = Nutricionista::factory()->for($tienda)->create();

        $this->assertNotNull($nutricionista->tienda);
        $this->assertEquals($tienda->id, $nutricionista->tienda->id);
    }
}
