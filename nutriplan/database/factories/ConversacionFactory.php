<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversacionFactory extends Factory
{
    public function definition(): array
    {
        $cita = Cita::factory()->create();
        return [
            'paciente_id' => $cita->paciente_id,
            'nutricionista_id' => $cita->nutricionista_id,
            'cita_id' => $cita->id,
            'colaboracion' => fake()->word(),
            'porcentaje' => fake()->numberBetween(0, 100),
            'mensaje_resumen' => fake()->sentence(),
            'creado_en' => now(),
        ];
    }
}
