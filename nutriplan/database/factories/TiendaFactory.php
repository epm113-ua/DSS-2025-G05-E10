<?php

namespace Database\Factories;

use App\Models\Tienda;
use Illuminate\Database\Eloquent\Factories\Factory;

class TiendaFactory extends Factory
{
    protected $model = Tienda::class;

    public function definition(): array
    {
        return [
            'nombre_tienda' => $this->faker->company(),
        ];
    }
}