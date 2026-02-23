<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        $facturas = DB::table('facturas')->pluck('id')->all();
        if (empty($facturas)) return;

        foreach ($facturas as $facturaId) {
            $num = rand(1, 2); // 1..* pagos por factura
            for ($i = 0; $i < $num; $i++) {
                DB::table('pagos')->insert([
                    'factura_id' => $facturaId,
                    'nombre_titular' => ['Ana', 'Luis', 'Marta', 'Juan', 'Sara'][array_rand(['Ana','Luis','Marta','Juan','Sara'])] . ' ' . ['García','Pérez','López','Ruiz'][array_rand(['García','Pérez','López','Ruiz'])],
                    'fecha_pago' => now()->subDays(rand(0, 60)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}