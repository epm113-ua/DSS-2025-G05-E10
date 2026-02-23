<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaIngrediente extends Model
{
    use HasFactory;

    protected $table = 'oferta_ingredientes';

    protected $fillable = ['ingrediente_id', 'tienda_id', 'nombre', 'descripcion_oferta'];

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }
}
