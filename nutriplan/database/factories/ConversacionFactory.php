<?php

namespace Database\Factories;

use App\Models\Conversacion;
use App\Models\Paciente;
use App\Models\Nutricionista;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversacionFactory extends Factory
{
    protected $model = Conversacion::class;

    public function definition(): array
    {
        return [
            'paciente_id' => Paciente::factory(),
            'nutricionista_id' => Nutricionista::factory(),
            'colaboracion' => $this->faker->randomElement(['Chat', 'Seguimiento', 'Consulta rápida']),
            'porcentaje' => $this->faker->numberBetween(0, 100),
            'mensaje_resumen' => $this->faker->optional()->sentence(8),
            'creado_en' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}