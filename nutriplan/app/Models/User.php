<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROL_ADMIN         = 'admin';
    const ROL_NUTRICIONISTA = 'nutricionista';
    const ROL_PACIENTE      = 'paciente';

    protected $fillable = ['name', 'email', 'password', 'is_admin', 'rol'];
    protected $hidden   = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    public function esAdmin(): bool         { return $this->rol === self::ROL_ADMIN; }
    public function esNutricionista(): bool { return $this->rol === self::ROL_NUTRICIONISTA; }
    public function esPaciente(): bool      { return $this->rol === self::ROL_PACIENTE; }

    public function tieneRol(string ...$roles): bool
    {
        return in_array($this->rol, $roles, true);
    }

    public function rutaInicio(): string
    {
        return match ($this->rol) {
            self::ROL_PACIENTE      => route('paciente.mi-dia'),
            self::ROL_NUTRICIONISTA => route('dashboard'),
            default                 => route('dashboard'),
        };
    }

    public function paciente()      { return $this->hasOne(Paciente::class); }
    public function nutricionista() { return $this->hasOne(Nutricionista::class); }
}
