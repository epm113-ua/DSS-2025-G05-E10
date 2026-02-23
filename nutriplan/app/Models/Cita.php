<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model
{
    use HasFactory;
    protected $fillable = [
        'nutricionista_id',
        'paciente_id',
        'inicio',
        'fin',
        'estado',
        'motivo',
    ];

    protected $casts = [
        'inicio' => 'datetime',
        'fin' => 'datetime',
    ];

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
}