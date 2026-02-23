<?php

namespace Database\Factories;

use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredienteFactory extends Factory
{
    protected $model = Ingrediente::class;

    public function definition(): array
    {
        return [
            'nombre' => ucfirst($this->faker->unique()->word()),
        ];
    }
}