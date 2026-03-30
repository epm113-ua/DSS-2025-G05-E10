<?php
namespace Database\Seeders;

use App\Models\Conversacion;
use App\Models\Mensaje;
use Illuminate\Database\Seeder;

class MensajeSeeder extends Seeder
{
    public function run(): void
    {
        Conversacion::all()->each(function (Conversacion $conversacion) {
            Mensaje::factory()->count(rand(3, 6))->create(['conversacion_id' => $conversacion->id]);
        });
    }
}