<?php

namespace Database\Factories;

use App\Models\Nutricionista;
use Illuminate\Database\Eloquent\Factories\Factory;

class NutricionistaFactory extends Factory
{
    protected $model = Nutricionista::class;

    public function definition(): array
    {
        return [
            'nombre_completo' => $this->faker->name(),
            'especialidad' => $this->faker->randomElement(['Deportiva','Clínica','Vegetariana','Pérdida de peso']),
            'ciudad' => $this->faker->city(),
            'valoracion_media' => $this->faker->randomFloat(1, 3, 5),
        ];
    }
}