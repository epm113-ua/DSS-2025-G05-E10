<?php
namespace Database\Seeders;

use App\Models\Factura;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class FacturaSeeder extends Seeder
{
    public function run(): void
    {
        Paciente::all()->each(function (Paciente $paciente) {
            Factura::factory()->count(rand(1, 2))->create(['paciente_id' => $paciente->id]);
        });
    }
}