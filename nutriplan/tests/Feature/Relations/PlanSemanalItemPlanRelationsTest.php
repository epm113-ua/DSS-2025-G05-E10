<?php

namespace Tests\Feature\Relations;

use App\Models\ItemPlan;
use App\Models\PlanSemanal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanSemanalItemPlanRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_semanal_has_many_item_plans(): void
    {
        $plan = PlanSemanal::factory()->create();

        $item1 = ItemPlan::factory()->for($plan)->slot(1, 'LUNCH')->create();
        $item2 = ItemPlan::factory()->for($plan)->slot(2, 'DINNER')->create();

        $this->assertCount(2, $plan->itemPlans);
        $this->assertTrue($plan->itemPlans->contains($item1));
    }

    public function test_item_plan_belongs_to_plan_semanal(): void
    {
        $plan = PlanSemanal::factory()->create();
        $item = ItemPlan::factory()->for($plan)->slot(1, 'LUNCH')->create();

        $this->assertNotNull($item->planSemanal);
        $this->assertEquals($plan->id, $item->planSemanal->id);
    }
}
