<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversacion extends Model
{
    use HasFactory;
    protected $table = 'conversaciones';
    protected $fillable = [
        'paciente_id',
        'nutricionista_id',
        'colaboracion',
        'porcentaje',
        'mensaje_resumen',
        'creado_en',
    ];

    protected $casts = [
        'creado_en' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function nutricionista()
    {
        return $this->belongsTo(Nutricionista::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}