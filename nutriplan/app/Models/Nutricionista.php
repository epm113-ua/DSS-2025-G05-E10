<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nutricionista extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_completo',
        'especialidad',
        'ciudad',
        'valoracion_media',
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function conversaciones()
    {
        return $this->hasMany(Conversacion::class);
    }
}