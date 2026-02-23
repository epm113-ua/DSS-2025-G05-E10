<?php

namespace Database\Factories;

use App\Models\Nutricionista;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecetaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nutricionista_id' => Nutricionista::factory(),
            'nombre' => fake()->words(3, true),
            'preparacion' => fake()->paragraph(),
            'calorias_kcal' => fake()->numberBetween(100, 800),
            'carbohidratos_g' => fake()->randomFloat(2, 0, 100),
            'grasas_g' => fake()->randomFloat(2, 0, 50),
            'ruta_foto' => null,
        ];
    }
}
