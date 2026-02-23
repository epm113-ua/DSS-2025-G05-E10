<?php

namespace Database\Factories;

use App\Models\Tienda;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tienda_id' => Tienda::factory(),
            'nombre' => fake()->word(),
        ];
    }
}
