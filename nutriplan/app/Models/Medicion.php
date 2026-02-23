<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Medicion extends Model
{
    use HasFactory;
    protected $table = 'mediciones';
    protected $fillable = [
        'paciente_id',
        'fecha_medicion',
        'peso_kg',
        'altura_cm',
        'porcentaje_grasa',
    ];

    protected $casts = [
        'fecha_medicion' => 'date',
        'peso_kg' => 'decimal:2',
        'porcentaje_grasa' => 'decimal:2',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}