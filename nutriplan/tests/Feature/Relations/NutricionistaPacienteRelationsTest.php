<?php

namespace Tests\Feature\Relations;

use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NutricionistaPacienteRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_nutricionista_has_many_pacientes(): void
    {
        $nutri = Nutricionista::factory()->create();
        $pacientes = Paciente::factory()->count(3)->for($nutri)->create();

        $this->assertCount(3, $nutri->pacientes);
        $this->assertTrue($nutri->pacientes->contains($pacientes->first()));
    }

    public function test_paciente_belongs_to_nutricionista(): void
    {
        $nutri = Nutricionista::factory()->create();
        $paciente = Paciente::factory()->for($nutri)->create();

        $this->assertNotNull($paciente->nutricionista);
        $this->assertEquals($nutri->id, $paciente->nutricionista->id);
    }
}