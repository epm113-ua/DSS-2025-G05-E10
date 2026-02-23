<?php

namespace Database\Factories;

use App\Models\Ingrediente;
use App\Models\Tienda;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfertaIngredienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ingrediente_id'    => Ingrediente::factory(),
            'tienda_id'         => Tienda::factory(),
            'nombre'            => fake()->words(2, true),
            'descripcion_oferta'=> fake()->sentence(),
        ];
    }
}
