<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutricionista extends Model
{
    use HasFactory;

    protected $fillable = ['tienda_id', 'nombre_completo', 'especialidad', 'ciudad', 'valoracion_media'];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
