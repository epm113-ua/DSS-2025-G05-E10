<?php

namespace Tests\Feature\Relations;

use App\Models\Conversacion;
use App\Models\Mensaje;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversacionMensajeRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_conversacion_has_many_mensajes(): void
    {
        $conv = Conversacion::factory()->create();
        $mensajes = Mensaje::factory()->count(3)->for($conv)->create();

        $this->assertCount(3, $conv->mensajes);
        $this->assertTrue($conv->mensajes->contains($mensajes->first()));
    }

    public function test_mensaje_belongs_to_conversacion(): void
    {
        $conv = Conversacion::factory()->create();
        $mensaje = Mensaje::factory()->for($conv)->create();

        $this->assertNotNull($mensaje->conversacion);
        $this->assertEquals($conv->id, $mensaje->conversacion->id);
    }
}