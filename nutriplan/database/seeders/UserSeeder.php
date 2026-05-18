<?php

namespace Database\Seeders;

use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@nutriplan.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'rol'      => User::ROL_ADMIN,
                'is_admin' => true,
            ]
        );

        // ── Nutricionistas (vinculamos los seedados) ──────────
        $passwords = [
            'laura@nutriplan.com'   => 'Laura Sánchez',
            'carlos@nutriplan.com'  => 'Carlos Pérez',
            'marta@nutriplan.com'   => 'Marta Ruiz',
            'diego@nutriplan.com'   => 'Diego Martín',
        ];

        foreach ($passwords as $email => $nombre) {
            $nutricionista = Nutricionista::whereNull('user_id')
                ->where('nombre_completo', $nombre)
                ->first();

            if (! $nutricionista) continue;

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $nombre,
                    'password' => Hash::make('password'),
                    'rol'      => User::ROL_NUTRICIONISTA,
                ]
            );

            $nutricionista->update(['user_id' => $user->id]);
        }

        // ── Pacientes (vinculamos los seedados) ───────────────
        Paciente::whereNull('user_id')->each(function (Paciente $paciente) {
            $slug  = \Illuminate\Support\Str::slug($paciente->nombre_completo);
            $email = "{$slug}@paciente.nutriplan.test";
            $i     = 1;
            while (User::where('email', $email)->exists()) {
                $email = "{$slug}-{$i}@paciente.nutriplan.test";
                $i++;
            }

            $user = User::create([
                'name'     => $paciente->nombre_completo,
                'email'    => $email,
                'password' => Hash::make('password'),
                'rol'      => User::ROL_PACIENTE,
            ]);

            $paciente->update(['user_id' => $user->id]);
        });
    }
}
