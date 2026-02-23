<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tienda extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_tienda',
    ];

    public function ofertas()
    {
        return $this->hasMany(OfertaIngrediente::class);
    }
}