<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSemanalSeeder extends Seeder
{
    public function run(): void
    {
        $citas = DB::table('citas')->pluck('id')->all();
        if (empty($citas)) return;

        foreach ($citas as $citaId) {
            $num = rand(0, 2);
            for ($i = 0; $i < $num; $i++) {
                DB::table('plan_semanal')->insert([
                    'cita_id' => $citaId,
                    'semanal_inicio' => now()->startOfWeek()->addWeeks(rand(-2, 2))->toDateString(),
                    'notas' => 'Plan semanal generado para la cita ' . $citaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}