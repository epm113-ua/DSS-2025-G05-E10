<?php

namespace Database\Factories;

use App\Models\OfertaIngrediente;
use App\Models\Tienda;
use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfertaIngredienteFactory extends Factory
{
    protected $model = OfertaIngrediente::class;

    public function definition(): array
    {
        return [
            'tienda_id' => Tienda::factory(),
            'ingrediente_id' => Ingrediente::factory(),
            'nombre' => 'Oferta ' . $this->faker->numberBetween(10, 60) . '%',
            'descripcion_oferta' => $this->faker->sentence(8),
        ];
    }
}