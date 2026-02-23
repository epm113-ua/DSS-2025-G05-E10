<?php

namespace Database\Factories;

use App\Models\PlanSemanal;
use App\Models\Cita;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanSemanalFactory extends Factory
{
    protected $model = PlanSemanal::class;

    public function definition(): array
    {
        return [
            'cita_id' => Cita::factory(),
            'semanal_inicio' => $this->faker->dateTimeBetween('-8 weeks', '+8 weeks')->format('Y-m-d'),
            'notas' => $this->faker->optional()->sentence(8),
        ];
    }
}