<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $nutricionistas = DB::table('nutricionistas')->pluck('id')->all();
        if (empty($nutricionistas)) return;

        $objetivos = [
            'Perder peso de forma sostenible',
            'Ganar masa muscular',
            'Mejorar hábitos alimenticios',
            'Plan vegetariano equilibrado',
            'Controlar colesterol y azúcar',
        ];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('pacientes')->insert([
                'nutricionista_id' => $nutricionistas[$i % count($nutricionistas)],
                'nombre_completo' => "Paciente Demo {$i}",
                'fecha_nacimiento' => now()->subYears(rand(18, 60))->subDays(rand(0, 365))->toDateString(),
                'ciudad' => ['Madrid','Valencia','Sevilla','Bilbao','Zaragoza'][rand(0,4)],
                'objetivos' => $objetivos[rand(0, count($objetivos)-1)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}