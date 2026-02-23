<?php

namespace Database\Factories;

use App\Models\Tienda;
use Illuminate\Database\Eloquent\Factories\Factory;

class NutricionistaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tienda_id'        => Tienda::factory(),
            'nombre_completo'  => fake()->name(),
            'especialidad'     => fake()->word(),
            'ciudad'           => fake()->city(),
            'valoracion_media' => fake()->randomFloat(1, 1, 5),
        ];
    }
}
