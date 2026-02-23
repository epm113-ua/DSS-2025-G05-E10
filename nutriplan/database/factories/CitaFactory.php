<?php

namespace Database\Factories;

use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitaFactory extends Factory
{
    public function definition(): array
    {
        $inicio = fake()->dateTimeBetween('-1 month', '+1 month');
        $fin = (clone $inicio)->modify('+1 hour');
        return [
            'nutricionista_id' => Nutricionista::factory(),
            'paciente_id'      => Paciente::factory(),
            'inicio'           => $inicio,
            'fin'              => $fin,
            'estado'           => fake()->randomElement(['pendiente', 'completada', 'cancelada']),
            'motivo'           => fake()->sentence(),
        ];
    }
}
