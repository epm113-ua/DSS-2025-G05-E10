<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfertaIngredienteSeeder extends Seeder
{
    public function run(): void
    {
        $tiendas = DB::table('tiendas')->pluck('id')->all();
        $ingredientes = DB::table('ingredientes')->pluck('id')->all();

        if (empty($tiendas) || empty($ingredientes)) return;

        foreach ($ingredientes as $ingId) {
            $num = rand(0, 2);
            for ($i = 0; $i < $num; $i++) {
                DB::table('oferta_ingredientes')->insert([
                    'tienda_id' => $tiendas[array_rand($tiendas)],
                    'ingrediente_id' => $ingId,
                    'nombre' => 'Oferta ' . rand(10, 60) . '%',
                    'descripcion_oferta' => 'Descuento especial por tiempo limitado',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}