<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TiendaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre_tienda' => fake()->company(),
        ];
    }
}
