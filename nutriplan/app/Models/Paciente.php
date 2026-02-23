<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nutricionista_id',
        'nombre_completo',
        'fecha_nacimiento',
        'ciudad',
        'objetivos',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function nutricionista()
    {
        return $this->belongsTo(Nutricionista::class);
    }

    public function mediciones()
    {
        return $this->hasMany(Medicion::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function conversaciones()
    {
        return $this->hasMany(Conversacion::class);
    }
}