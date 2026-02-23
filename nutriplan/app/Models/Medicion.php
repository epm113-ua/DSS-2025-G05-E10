<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicion extends Model
{
    use HasFactory;

    protected $table = 'mediciones';

    protected $fillable = ['paciente_id', 'fecha_medicion', 'peso_kg', 'altura_cm', 'porcentaje_grasa'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
