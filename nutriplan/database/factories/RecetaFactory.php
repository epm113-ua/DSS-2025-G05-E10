<?php

namespace Database\Factories;

use App\Models\Receta;
use App\Models\Nutricionista;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecetaFactory extends Factory
{
    protected $model = Receta::class;

    public function definition(): array
    {
        return [
            'nutricionista_id' => Nutricionista::factory(),
            'nombre' => ucfirst($this->faker->words(3, true)),
            'preparacion' => $this->faker->paragraph(2),
            'calorias_kcal' => $this->faker->numberBetween(200, 900),
            'carbohidratos_g' => $this->faker->randomFloat(2, 5, 150),
            'grasas_g' => $this->faker->randomFloat(2, 2, 80),
            'ruta_foto' => $this->faker->optional()->imageUrl(),
        ];
    }
}