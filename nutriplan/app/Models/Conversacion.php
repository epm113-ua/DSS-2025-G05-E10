<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    use HasFactory;

    protected $table = 'conversaciones';

    protected $fillable = ['paciente_id', 'cita_id', 'nutricionista_id', 'colaboracion', 'porcentaje', 'mensaje_resumen', 'creado_en'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function nutricionista()
    {
        return $this->belongsTo(Nutricionista::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
