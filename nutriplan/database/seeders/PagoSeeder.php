<?php
namespace Database\Seeders;

use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Database\Seeder;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        Factura::all()->each(function (Factura $factura) {
            Pago::factory()->count(rand(1, 2))->create(['factura_id' => $factura->id]);
        });
    }
}