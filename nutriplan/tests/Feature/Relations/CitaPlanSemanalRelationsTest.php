<?php

namespace Tests\Feature\Relations;

use App\Models\Cita;
use App\Models\PlanSemanal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitaPlanSemanalRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_cita_has_many_planes_semanales(): void
    {
        $cita = Cita::factory()->create();
        $planes = PlanSemanal::factory()->count(2)->for($cita)->create();

        $this->assertCount(2, $cita->planesSemanales);
        $this->assertTrue($cita->planesSemanales->contains($planes->first()));
    }

    public function test_plan_semanal_belongs_to_cita(): void
    {
        $cita = Cita::factory()->create();
        $plan = PlanSemanal::factory()->for($cita)->create();

        $this->assertNotNull($plan->cita);
        $this->assertEquals($cita->id, $plan->cita->id);
    }
}
