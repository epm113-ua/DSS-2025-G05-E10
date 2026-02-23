<?php

namespace Tests\Feature\Relations;

use App\Models\Conversacion;
use App\Models\Mensaje;
use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversacionMensajeRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_conversacion_belongs_to_paciente_and_nutricionista(): void
    {
        $paciente = Paciente::factory()->create();
        $nutri = Nutricionista::factory()->create();

        $conv = Conversacion::factory()->state([
            'paciente_id' => $paciente->id,
            'nutricionista_id' => $nutri->id,
        ])->create();

        $this->assertEquals($paciente->id, $conv->paciente->id);
        $this->assertEquals($nutri->id, $conv->nutricionista->id);
    }

    public function test_conversacion_has_many_mensajes_and_mensaje_belongs_to_conversacion(): void
    {
        $conv = Conversacion::factory()->create();
        $mensajes = Mensaje::factory()->count(3)->for($conv)->create();

        $this->assertCount(3, $conv->mensajes);
        $this->assertTrue($conv->mensajes->contains($mensajes->first()));
        $this->assertEquals($conv->id, $mensajes->first()->conversacion->id);
    }
}