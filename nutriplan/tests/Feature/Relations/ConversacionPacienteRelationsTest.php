<?php

namespace Tests\Feature\Relations;

use App\Models\Conversacion;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversacionPacienteRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_conversacion_belongs_to_paciente(): void
    {
        $paciente = Paciente::factory()->create();
        $conv = Conversacion::factory()->state(['paciente_id' => $paciente->id])->create();

        $this->assertNotNull($conv->paciente);
        $this->assertEquals($paciente->id, $conv->paciente->id);
    }
}
