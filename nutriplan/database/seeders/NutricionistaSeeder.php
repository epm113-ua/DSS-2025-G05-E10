<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NutricionistaSeeder extends Seeder
{
    public function run(): void
    {
        $tiendas = DB::table('tiendas')->pluck('id')->all();

        $data = [
            ['nombre_completo' => 'Laura Sánchez', 'especialidad' => 'Deportiva', 'ciudad' => 'Madrid', 'valoracion_media' => 4.6],
            ['nombre_completo' => 'Carlos Pérez', 'especialidad' => 'Clínica',   'ciudad' => 'Valencia', 'valoracion_media' => 4.2],
            ['nombre_completo' => 'Marta Ruiz',    'especialidad' => 'Vegetariana', 'ciudad' => 'Sevilla', 'valoracion_media' => 4.8],
            ['nombre_completo' => 'Diego Martín',  'especialidad' => 'Pérdida de peso', 'ciudad' => 'Bilbao', 'valoracion_media' => 4.1],
        ];

        foreach ($data as $i => $n) {
            DB::table('nutricionistas')->insert([
                // quita tienda_id si no existe en tu BD

                'nombre_completo' => $n['nombre_completo'],
                'especialidad' => $n['especialidad'],
                'ciudad' => $n['ciudad'],
                'valoracion_media' => $n['valoracion_media'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}