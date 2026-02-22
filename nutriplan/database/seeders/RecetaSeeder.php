<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecetaSeeder extends Seeder
{
    public function run(): void
    {
        $nutricionistas = DB::table('nutricionistas')->pluck('id')->all();
        if (empty($nutricionistas)) return;

        $recetasBase = [
            ['Bowl de avena', 'Mezcla avena con yogur y fruta.'],
            ['Ensalada de garbanzos', 'Garbanzos con tomate, cebolla y aceite de oliva.'],
            ['Pollo con arroz integral', 'Plancha de pollo + arroz integral cocido.'],
            ['Salmón al horno', 'Salmón al horno con verduras.'],
            ['Tortilla de espinacas', 'Huevos batidos con espinacas salteadas.'],
            ['Pasta integral con pavo', 'Pasta integral con pavo y salsa ligera.'],
        ];

        $i = 0;
        foreach ($nutricionistas as $nutriId) {
            $num = rand(5, 10);
            for ($k = 0; $k < $num; $k++) {
                $base = $recetasBase[($i + $k) % count($recetasBase)];

                DB::table('recetas')->insert([
                    'nutricionista_id' => $nutriId,
                    'nombre' => $base[0] . " #".($k+1),
                    'preparacion' => $base[1],
                    'calorias_kcal' => rand(250, 850),
                    'carbohidratos_g' => number_format(rand(10, 120) + rand(0, 99)/100, 2, '.', ''),
                    'grasas_g' => number_format(rand(5, 60) + rand(0, 99)/100, 2, '.', ''),
                    'ruta_foto' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $i++;
        }
    }
}