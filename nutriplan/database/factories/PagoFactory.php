<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    protected $model = Pago::class;

    public function definition(): array
    {
        return [
            'factura_id' => Factura::factory(),
            'nombre_titular' => $this->faker->name(),
            'fecha_pago' => $this->faker->dateTimeBetween('-60 days', 'now'),
        ];
    }
}