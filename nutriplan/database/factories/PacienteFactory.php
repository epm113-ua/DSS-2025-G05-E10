<?php

namespace Database\Factories;

use App\Models\Nutricionista;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nutricionista_id' => Nutricionista::factory(),
            'nombre_completo' => fake()->name(),
            'fecha_nacimiento' => fake()->date(),
            'ciudad' => fake()->city(),
            'objetivos' => fake()->sentence(),
        ];
    }
}
