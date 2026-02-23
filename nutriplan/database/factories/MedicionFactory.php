<?php

namespace Database\Factories;

use App\Models\Medicion;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicionFactory extends Factory
{
    protected $model = Medicion::class;

    public function definition(): array
    {
        return [
            'paciente_id' => Paciente::factory(),
            'fecha_medicion' => $this->faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
            'peso_kg' => $this->faker->randomFloat(2, 50, 120),
            'altura_cm' => $this->faker->numberBetween(150, 200),
            'porcentaje_grasa' => $this->faker->optional(0.8)->randomFloat(2, 8, 35), // a veces null
        ];
    }
}