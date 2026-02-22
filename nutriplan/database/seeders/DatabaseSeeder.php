<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TiendaSeeder::class,
            NutricionistaSeeder::class,
            PacienteSeeder::class,
            IngredienteSeeder::class,
            RecetaSeeder::class,
            IngredienteRecetaSeeder::class, // pivot (crear)
            OfertaIngredienteSeeder::class,
            CitaSeeder::class,
            PlanSemanalSeeder::class,
            ItemPlanSeeder::class,          // crear
            MedicionSeeder::class,
            FacturaSeeder::class,
            PagoSeeder::class,
            ConversacionSeeder::class,
            MensajeSeeder::class,
        ]);
    }
}