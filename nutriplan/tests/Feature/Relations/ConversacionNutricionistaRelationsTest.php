<?php

namespace Tests\Feature\Relations;

use App\Models\Conversacion;
use App\Models\Nutricionista;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversacionNutricionistaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_conversacion_belongs_to_nutricionista(): void
    {
        $nutri = Nutricionista::factory()->create();
        $conv = Conversacion::factory()->state(['nutricionista_id' => $nutri->id])->create();

        $this->assertNotNull($conv->nutricionista);
        $this->assertEquals($nutri->id, $conv->nutricionista->id);
    }
}
