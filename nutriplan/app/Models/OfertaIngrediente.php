<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfertaIngrediente extends Model
{
    use HasFactory;
    protected $table = 'oferta_ingredientes';

    protected $fillable = [
        'tienda_id',
        'ingrediente_id',
        'nombre',
        'descripcion_oferta',
    ];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }
}