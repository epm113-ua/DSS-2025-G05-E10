<?php
namespace App\Services;

use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroUsuarioService
{
    public function registrarPaciente(array $datos): User
    {
        return DB::transaction(function () use ($datos) {
            $user = User::create([
                'name'     => $datos['name'],
                'email'    => $datos['email'],
                'password' => Hash::make($datos['password']),
                'rol'      => User::ROL_PACIENTE,
            ]);
            Paciente::create([
                'user_id'          => $user->id,
                'nutricionista_id' => $datos['nutricionista_id'],
                'nombre_completo'  => $datos['name'],
            ]);
            return $user;
        });
    }

    public function registrarNutricionista(array $datos): User
    {
        return DB::transaction(function () use ($datos) {
            $user = User::create([
                'name'     => $datos['name'],
                'email'    => $datos['email'],
                'password' => Hash::make($datos['password']),
                'rol'      => User::ROL_NUTRICIONISTA,
            ]);
            Nutricionista::create([
                'user_id'          => $user->id,
                'tienda_id'        => null,
                'nombre_completo'  => $datos['name'],
                'especialidad'     => $datos['especialidad'] ?? 'General',
                'ciudad'           => $datos['ciudad'] ?? '',
                'valoracion_media' => 0,
            ]);
            return $user;
        });
    }
}
