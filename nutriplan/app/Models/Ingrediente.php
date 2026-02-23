<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingrediente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
    ];

    public function recetas()
    {
        return $this->belongsToMany(
            Receta::class,
            'ingrediente_receta',
            'ingrediente_id',
            'receta_id'
        );
    }

    public function ofertas()
    {
        return $this->hasMany(OfertaIngrediente::class);
    }
}