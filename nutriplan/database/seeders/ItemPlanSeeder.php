<?php
namespace Database\Seeders;

use App\Models\ItemPlan;
use App\Models\PlanSemanal;
use App\Models\Receta;
use Illuminate\Database\Seeder;

class ItemPlanSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['BREAKFAST', 'LUNCH', 'SNACK', 'DINNER'];
        PlanSemanal::all()->each(function (PlanSemanal $plan) use ($tipos) {
            $recetaId = Receta::inRandomOrder()->first()->id;
            foreach (range(1, 7) as $dia) {
                $tipo = $tipos[array_rand($tipos)];
                ItemPlan::factory()->slot($dia, $tipo)->create([
                    'plan_semanal_id' => $plan->id,
                    'receta_id'       => $recetaId,
                ]);
            }
        });
    }
}