<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacturaSeeder extends Seeder
{
    public function run(): void
    {
        //Creamos entre 8 y 15 facturas 
        $cantidad = rand(8, 15);

        for ($i = 1; $i <= $cantidad; $i++) {
            DB::table('facturas')->insert([
                'numero_factura' => 'F-' . now()->format('Ymd') . '-' . str_pad((string)$i, 4, '0', STR_PAD_LEFT),
                'pagado_en' => (rand(0, 1) === 1) ? now()->subDays(rand(0, 60)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}