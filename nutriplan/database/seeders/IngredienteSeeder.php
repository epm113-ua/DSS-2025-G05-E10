<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredienteSeeder extends Seeder
{
    public function run(): void
    {
        $tiendas = DB::table('tiendas')->pluck('id')->all();

        $ingredientes = [
            'Avena','Arroz integral','Pollo','Salmón','Garbanzos','Lentejas','Tomate','Espinacas','Plátano','Manzana',
            'Yogur natural','Huevos','Aceite de oliva','Aguacate','Almendras','Leche','Pasta integral','Pavo','Brócoli','Queso fresco'
        ];

        foreach ($ingredientes as $i => $nombre) {
            DB::table('ingredientes')->insert([
                'tienda_id' => $tiendas[$i % count($tiendas)],
                'nombre' => $nombre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}