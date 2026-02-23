<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receta extends Model
{
    use HasFactory;
    protected $fillable = [
        'nutricionista_id',
        'nombre',
        'preparacion',
        'calorias_kcal',
        'carbohidratos_g',
        'grasas_g',
        'ruta_foto',
    ];

    protected $casts = [
        'carbohidratos_g' => 'decimal:2',
        'grasas_g' => 'decimal:2',
    ];

    public function nutricionista()
    {
        return $this->belongsTo(Nutricionista::class);
    }

    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'ingrediente_receta',
            'receta_id',
            'ingrediente_id'
        );
    }
}