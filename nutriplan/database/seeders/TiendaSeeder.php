<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiendaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tiendas')->insert([
            ['nombre_tienda' => 'Mercado Verde', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_tienda' => 'BioMarket Centro', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}