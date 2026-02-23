<?php

namespace Database\Factories;

use App\Models\ItemPlan;
use App\Models\PlanSemanal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemPlanFactory extends Factory
{
    protected $model = ItemPlan::class;

    private const TIPOS = ['BREAKFAST', 'LUNCH', 'SNACK', 'DINNER'];

    public function definition(): array
    {
        return [
            'plan_semanal_id' => PlanSemanal::factory(),
            'dia_semana' => $this->faker->numberBetween(1, 7),
            'tipo_comida' => $this->faker->randomElement(self::TIPOS),
            'notas' => $this->faker->optional()->sentence(8),
        ];
    }

    //State útil para evitar el UNIQUE en tests:
    
    public function slot(int $dia, string $tipo): self
    {
        return $this->state(fn () => [
            'dia_semana' => $dia,
            'tipo_comida' => $tipo,
        ]);
    }
}