<?php

namespace Tests\Feature\Relations;

use App\Models\Ingrediente;
use App\Models\OfertaIngrediente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredienteOfertaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ingrediente_has_many_ofertas(): void
    {
        $ingrediente = Ingrediente::factory()->create();
        $ofertas = OfertaIngrediente::factory()->count(2)->for($ingrediente)->create();

        $this->assertCount(2, $ingrediente->ofertas);
        $this->assertTrue($ingrediente->ofertas->contains($ofertas->first()));
    }

    public function test_oferta_belongs_to_ingrediente(): void
    {
        $ingrediente = Ingrediente::factory()->create();
        $oferta = OfertaIngrediente::factory()->for($ingrediente)->create();

        $this->assertNotNull($oferta->ingrediente);
        $this->assertEquals($ingrediente->id, $oferta->ingrediente->id);
    }
}
