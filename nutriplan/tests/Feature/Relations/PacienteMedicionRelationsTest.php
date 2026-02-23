<?php

namespace Tests\Feature\Relations;

use App\Models\Paciente;
use App\Models\Medicion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteMedicionRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_paciente_has_many_mediciones(): void
    {
        $paciente = Paciente::factory()->create();
        $mediciones = Medicion::factory()->count(4)->for($paciente)->create();

        $this->assertCount(4, $paciente->mediciones);
        $this->assertTrue($paciente->mediciones->contains($mediciones->first()));
    }

    public function test_medicion_belongs_to_paciente(): void
    {
        $paciente = Paciente::factory()->create();
        $medicion = Medicion::factory()->for($paciente)->create();

        $this->assertNotNull($medicion->paciente);
        $this->assertEquals($paciente->id, $medicion->paciente->id);
    }
}