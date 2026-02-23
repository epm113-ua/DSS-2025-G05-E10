<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_tienda'];

    public function nutricionistas()
    {
        return $this->hasMany(Nutricionista::class);
    }

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class);
    }

    public function ofertas()
    {
        return $this->hasMany(OfertaIngrediente::class);
    }
}
