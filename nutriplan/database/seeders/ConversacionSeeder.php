<?php
namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Conversacion;
use Illuminate\Database\Seeder;

class ConversacionSeeder extends Seeder
{
    public function run(): void
    {
        Cita::all()->each(function (Cita $cita) {
            if (rand(0, 1)) {
                Conversacion::factory()->create([
                    'cita_id'          => $cita->id,
                    'paciente_id'      => $cita->paciente_id,
                    'nutricionista_id' => $cita->nutricionista_id,
                ]);
            }
        });
    }
}