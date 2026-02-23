<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = ['tienda_id', 'nombre'];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'ingrediente_receta');
    }

    public function ofertas()
    {
        return $this->hasMany(OfertaIngrediente::class);
    }
}
