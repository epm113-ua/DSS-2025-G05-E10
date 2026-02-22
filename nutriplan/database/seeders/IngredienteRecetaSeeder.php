<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredienteRecetaSeeder extends Seeder
{
    public function run(): void
    {
        $ingredientes = DB::table('ingredientes')->pluck('id')->all();
        $recetas = DB::table('recetas')->pluck('id')->all();

        if (empty($ingredientes) || empty($recetas)) return;

        foreach ($recetas as $recetaId) {
            $num = rand(3, 8);
            $seleccion = collect($ingredientes)->shuffle()->take($num);

            foreach ($seleccion as $ingId) {
                // evita duplicados si no tienes PK/unique en pivot
                DB::table('ingrediente_receta')->updateOrInsert([
                    'ingrediente_id' => $ingId,
                    'receta_id' => $recetaId,
                ], []);
            }
        }
    }
}