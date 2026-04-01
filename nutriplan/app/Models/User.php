<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'is_admin'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    /**
     * Devuelve el usuario activo simulado.
     * En la siguiente entrega se sustituirá por Auth::user().
     */
    public static function currentUser(): self
    {
        return self::firstOrCreate(
            ['email' => 'admin@nutriplan.com'],
            [
                'name'     => 'Administrador NutriPlan',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );
    }

    public function esAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * Indica si el usuario está actuando en modo admin ahora mismo.
     * Usa la sesión para permitir cambiar de rol sin autenticación real.
     */
    public static function modoAdmin(): bool
    {
        // Solo puede ser admin si el usuario tiene el flag is_admin
        if (!self::currentUser()->esAdmin()) {
            return false;
        }
        // Por defecto, el admin empieza en modo admin
        return session('modo_admin', true);
    }
}
