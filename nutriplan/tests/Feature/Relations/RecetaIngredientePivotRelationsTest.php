<?php

namespace Tests\Feature\Relations;

use App\Models\Ingrediente;
use App\Models\Receta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecetaIngredientePivotRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_receta_belongs_to_many_ingredientes(): void
    {
        $receta = Receta::factory()->create();
        $ingredientes = Ingrediente::factory()->count(3)->create();

        $receta->ingredientes()->attach($ingredientes->pluck('id'));

        $this->assertCount(3, $receta->fresh()->ingredientes);
        $this->assertTrue($receta->ingredientes->contains($ingredientes->first()));
    }

    public function test_ingrediente_belongs_to_many_recetas(): void
    {
        $ingrediente = Ingrediente::factory()->create();
        $recetas = Receta::factory()->count(2)->create();

        $ingrediente->recetas()->attach($recetas->pluck('id'));

        $this->assertCount(2, $ingrediente->fresh()->recetas);
        $this->assertTrue($ingrediente->recetas->contains($recetas->first()));
    }
}