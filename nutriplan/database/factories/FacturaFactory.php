<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'paciente_id'    => Paciente::factory(),
            'numero_factura' => fake()->unique()->numerify('FAC-#####'),
            'pagado_en'      => null,
        ];
    }
}
