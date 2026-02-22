<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversacionSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = DB::table('pacientes')->get(['id', 'nutricionista_id']);
        if ($pacientes->isEmpty()) return;

        $colabs = ['Chat', 'Seguimiento', 'Consulta rápida'];
        foreach ($pacientes as $p) {
            $num = rand(0, 2);
            for ($i = 0; $i < $num; $i++) {
                DB::table('conversaciones')->insert([
                    'paciente_id' => $p->id,
                    'nutricionista_id' => $p->nutricionista_id,
                    'colaboracion' => $colabs[array_rand($colabs)],
                    'porcentaje' => rand(0, 100),
                    'mensaje_resumen' => (rand(0, 1) === 1) ? 'Resumen automático de la conversación' : null,
                    'creado_en' => now()->subDays(rand(0, 30)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}