<?php

namespace Database\Factories;

use App\Models\Cita;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanSemanalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cita_id'       => Cita::factory(),
            'semana_inicio' => fake()->date(),
            'notas'         => fake()->sentence(),
        ];
    }
}
