<?php

namespace Tests\Feature\Relations;

use App\Models\Cita;
use App\Models\Nutricionista;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NutricionistaCitaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_nutricionista_has_many_citas(): void
    {
        $nutri = Nutricionista::factory()->create();
        $citas = Cita::factory()->count(2)->for($nutri)->create();

        $this->assertCount(2, $nutri->citas);
        $this->assertTrue($nutri->citas->contains($citas->first()));
    }

    public function test_cita_belongs_to_nutricionista(): void
    {
        $nutri = Nutricionista::factory()->create();
        $cita = Cita::factory()->for($nutri)->create();

        $this->assertNotNull($cita->nutricionista);
        $this->assertEquals($nutri->id, $cita->nutricionista->id);
    }
}
