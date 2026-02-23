<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'paciente_id' => Paciente::factory(),
            'fecha_medicion' => fake()->date(),
            'peso_kg' => fake()->randomFloat(2, 40, 150),
            'altura_cm' => fake()->numberBetween(140, 210),
            'porcentaje_grasa' => fake()->randomFloat(2, 5, 40),
        ];
    }
}
