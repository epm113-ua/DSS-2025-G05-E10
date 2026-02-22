<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MensajeSeeder extends Seeder
{
    public function run(): void
    {
        $conversaciones = DB::table('conversaciones')->pluck('id')->all();
        $facturas = DB::table('facturas')->pluck('id')->all();

        if (empty($conversaciones)) return;

        $frases = [
            'Hola, ¿cómo vas con el plan?',
            'Recuerda hidratarte bien.',
            'Ajusta las raciones si tienes hambre.',
            'Te dejo recomendaciones para la semana.',
            '¿Puedes pasarme tu última medición?',
        ];

        foreach ($conversaciones as $convId) {
            $num = rand(3, 10);
            for ($i = 0; $i < $num; $i++) {
                $vinculaFactura = (!empty($facturas) && rand(0, 4) === 0); // ~20% con factura
                DB::table('mensajes')->insert([
                    'conversacion_id' => $convId,
                    'contenido' => $frases[array_rand($frases)],
                    'factura_id' => $vinculaFactura ? $facturas[array_rand($facturas)] : null,
                    'enviado_en' => now()->subMinutes(rand(0, 5000)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}