<?php

namespace Tests\Feature\Relations;

use App\Models\Nutricionista;
use App\Models\Receta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NutricionistaRecetaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_nutricionista_has_many_recetas(): void
    {
        $nutri = Nutricionista::factory()->create();
        $recetas = Receta::factory()->count(2)->for($nutri)->create();

        $this->assertCount(2, $nutri->recetas);
        $this->assertTrue($nutri->recetas->contains($recetas->first()));
    }

    public function test_receta_belongs_to_nutricionista(): void
    {
        $nutri = Nutricionista::factory()->create();
        $receta = Receta::factory()->for($nutri)->create();

        $this->assertNotNull($receta->nutricionista);
        $this->assertEquals($nutri->id, $receta->nutricionista->id);
    }
}