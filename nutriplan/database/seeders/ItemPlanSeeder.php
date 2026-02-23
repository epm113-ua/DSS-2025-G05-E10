<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemPlanSeeder extends Seeder
{
    public function run(): void
    {
        $planes = DB::table('plan_semanal')->pluck('id')->all();
        if (empty($planes)) return;

        $tipos = ['BREAKFAST', 'LUNCH', 'SNACK', 'DINNER'];

        foreach ($planes as $planId) {

            // Generamos todas las combinaciones posibles (7 días x 4 tipos = 28)
            $combinaciones = [];
            for ($dia = 1; $dia <= 7; $dia++) {
                foreach ($tipos as $tipo) {
                    $combinaciones[] = [$dia, $tipo];
                }
            }

            // Barajamos para que sea aleatorio
            shuffle($combinaciones);

            // Elegimos cuántos items crear (máx 28 para no violar el UNIQUE)
            $items = rand(7, 21);
            $items = min($items, count($combinaciones));

            for ($i = 0; $i < $items; $i++) {
                [$dia, $tipo] = $combinaciones[$i];

                DB::table('item_plans')->insert([
                    'plan_semanal_id' => $planId,
                    'dia_semana' => $dia,
                    'tipo_comida' => $tipo,
                    'notas' => (rand(0, 3) === 0) ? 'Ajustar raciones según objetivo' : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}