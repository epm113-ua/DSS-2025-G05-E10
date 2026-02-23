<?php

namespace Database\Factories;

use App\Models\Conversacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class MensajeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'conversacion_id' => Conversacion::factory(),
            'factura_id'      => null,
            'contenido'       => fake()->sentence(),
            'enviado_en'      => now(),
        ];
    }

    public function conFactura(): static
    {
        return $this->state(fn (array $attributes) => []);
    }
}
