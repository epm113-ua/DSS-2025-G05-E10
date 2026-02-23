<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = ['nutricionista_id', 'paciente_id', 'inicio', 'fin', 'estado', 'motivo'];

    public function nutricionista()
    {
        return $this->belongsTo(Nutricionista::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function planesSemanales()
    {
        return $this->hasMany(PlanSemanal::class);
    }

    public function conversaciones()
    {
        return $this->hasMany(Conversacion::class);
    }
}
