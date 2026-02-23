<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = DB::table('pacientes')->get(['id', 'nutricionista_id']);
        if ($pacientes->isEmpty()) return;

        $estados = ['SCHEDULED', 'CANCELLED', 'DONE'];
        $motivos = ['Revisión', 'Primera consulta', 'Seguimiento', 'Plan semanal', 'Ajuste de dieta'];

        foreach ($pacientes as $p) {
            $num = rand(2, 4);
            for ($i = 0; $i < $num; $i++) {
                $inicio = now()->addDays(rand(-30, 30))->setTime(rand(9, 19), [0, 30][rand(0,1)], 0);
                $fin = (clone $inicio)->addMinutes(30);

                DB::table('citas')->insert([
                    'nutricionista_id' => $p->nutricionista_id,
                    'paciente_id' => $p->id,
                    'inicio' => $inicio,
                    'fin' => $fin,
                    'estado' => $estados[array_rand($estados)],
                    'motivo' => $motivos[array_rand($motivos)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}