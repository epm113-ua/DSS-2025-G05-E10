<?php

namespace Database\Factories;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'factura_id' => Factura::factory(),
            'nombre_titular' => fake()->name(),
            'fecha_pago' => now(),
        ];
    }
}
