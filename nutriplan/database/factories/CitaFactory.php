<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitaFactory extends Factory
{
    protected $model = Cita::class;

    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('-30 days', '+30 days');
        $fin = (clone $inicio);
        $fin->modify('+30 minutes');

        return [
            'nutricionista_id' => Nutricionista::factory(),
            'paciente_id' => Paciente::factory(),
            'inicio' => $inicio, // si tu columna es date, Laravel lo formatea; si es datetime, perfecto
            'fin' => $fin,
            'estado' => $this->faker->randomElement(['SCHEDULED', 'CANCELLED', 'DONE']),
            'motivo' => $this->faker->randomElement(['Revisión','Primera consulta','Seguimiento','Plan semanal','Ajuste de dieta']),
        ];
    }
}