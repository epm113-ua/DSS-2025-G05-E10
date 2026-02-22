<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicionSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = DB::table('pacientes')->pluck('id')->all();
        if (empty($pacientes)) return;

        foreach ($pacientes as $pId) {
            $num = rand(2, 5);
            for ($i = 0; $i < $num; $i++) {
                DB::table('mediciones')->insert([
                    'paciente_id' => $pId,
                    'fecha_medicion' => now()->subDays(rand(0, 90))->toDateString(),
                    'peso_kg' => number_format(rand(55, 110) + rand(0, 99)/100, 2, '.', ''),
                    'altura_cm' => rand(150, 195),
                    'porcentaje_grasa' => (rand(0, 4) === 0) ? null : number_format(rand(8, 30) + rand(0, 99)/100, 2, '.', ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}