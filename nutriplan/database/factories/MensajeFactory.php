<?php

namespace Database\Factories;

use App\Models\Mensaje;
use App\Models\Conversacion;
use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

class MensajeFactory extends Factory
{
    protected $model = Mensaje::class;

    public function definition(): array
    {
        return [
            'conversacion_id' => Conversacion::factory(),
            'contenido' => $this->faker->sentence(10),
            'factura_id' => null,
            'enviado_en' => $this->faker->dateTimeBetween('-10 days', 'now'),
        ];
    }

    public function conFactura(): self
    {
        return $this->state(fn () => [
            'factura_id' => Factura::factory(),
        ]);
    }
}