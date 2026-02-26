<?php

namespace Tests\Feature\Relations;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PacienteCitaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_paciente_has_many_citas(): void
    {
        $paciente = Paciente::factory()->create();
        $citas = Cita::factory()->count(2)->for($paciente)->create();

        $this->assertCount(2, $paciente->citas);
        $this->assertTrue($paciente->citas->contains($citas->first()));
    }

    public function test_cita_belongs_to_paciente(): void
    {
        $paciente = Paciente::factory()->create();
        $cita = Cita::factory()->for($paciente)->create();

        $this->assertNotNull($cita->paciente);
        $this->assertEquals($paciente->id, $cita->paciente->id);
    }
}
