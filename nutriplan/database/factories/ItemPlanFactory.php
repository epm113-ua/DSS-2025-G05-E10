<?php

namespace Database\Factories;

use App\Models\PlanSemanal;
use App\Models\Receta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemPlanFactory extends Factory
{
    protected int $dia = 1;
    protected string $tipo = 'LUNCH';

    public function definition(): array
    {
        return [
            'plan_semanal_id' => PlanSemanal::factory(),
            'receta_id'       => Receta::factory(),
            'dia_semana'      => $this->dia,
            'tipo_comida'     => $this->tipo,
            'notas'           => null,
        ];
    }

    public function slot(int $dia, string $tipo): static
    {
        return $this->state(fn (array $attributes) => [
            'dia_semana'  => $dia,
            'tipo_comida' => $tipo,
        ]);
    }
}
