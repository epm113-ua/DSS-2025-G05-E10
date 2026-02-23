<?php

namespace Database\Factories;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    protected $model = Factura::class;

    public function definition(): array
    {
        return [
            'numero_factura' => 'F-' . $this->faker->unique()->numerify('########'),
            'pagado_en' => $this->faker->optional()->dateTimeBetween('-60 days', 'now'),
        ];
    }
}