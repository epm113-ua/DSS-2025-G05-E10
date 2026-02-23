<?php

namespace Tests\Feature\Relations;

use App\Models\Cita;
use App\Models\ItemPlan;
use App\Models\Paciente;
use App\Models\Nutricionista;
use App\Models\PlanSemanal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitaPlanSemanalItemPlanRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_paciente_has_many_citas_and_cita_belongs_to_paciente(): void
    {
        $paciente = Paciente::factory()->create();
        $cita = Cita::factory()->for($paciente)->create();

        $this->assertTrue($paciente->citas->contains($cita));
        $this->assertEquals($paciente->id, $cita->paciente->id);
    }

    public function test_nutricionista_has_many_citas_and_cita_belongs_to_nutricionista(): void
    {
        $nutri = Nutricionista::factory()->create();
        $cita = Cita::factory()->for($nutri)->create();

        $this->assertTrue($nutri->citas->contains($cita));
        $this->assertEquals($nutri->id, $cita->nutricionista->id);
    }

    public function test_cita_has_many_planes_semanales_and_plan_belongs_to_cita(): void
    {
        $cita = Cita::factory()->create();
        $planes = PlanSemanal::factory()->count(2)->for($cita)->create();

        $this->assertCount(2, $cita->planesSemanales);
        $this->assertTrue($cita->planesSemanales->contains($planes->first()));
        $this->assertEquals($cita->id, $planes->first()->cita->id);
    }

    public function test_plan_has_many_item_plans_and_item_belongs_to_plan(): void
    {
        $plan = PlanSemanal::factory()->create();

        // Evita violación UNIQUE (plan_semanal_id, dia_semana, tipo_comida)
        $item = ItemPlan::factory()->for($plan)->slot(1, 'LUNCH')->create();
        $item2 = ItemPlan::factory()->for($plan)->slot(2, 'DINNER')->create();

        $this->assertCount(2, $plan->itemPlans);
        $this->assertTrue($plan->itemPlans->contains($item));
        $this->assertEquals($plan->id, $item->planSemanal->id);
        $this->assertEquals($plan->id, $item2->planSemanal->id);
    }
}