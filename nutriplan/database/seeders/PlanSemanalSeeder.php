<?php
namespace Database\Seeders;

use App\Models\Cita;
use App\Models\PlanSemanal;
use Illuminate\Database\Seeder;

class PlanSemanalSeeder extends Seeder
{
    public function run(): void
    {
        Cita::all()->each(function (Cita $cita) {
            PlanSemanal::factory()->count(rand(1, 2))->create(['cita_id' => $cita->id]);
        });
    }
}