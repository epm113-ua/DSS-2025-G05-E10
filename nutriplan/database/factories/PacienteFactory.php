<?php

namespace Database\Factories;

use App\Models\Paciente;
use App\Models\Nutricionista;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'nutricionista_id' => Nutricionista::factory(),
            'nombre_completo' => $this->faker->name(),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'ciudad' => $this->faker->city(),
            'objetivos' => $this->faker->sentence(10),
        ];
    }
}