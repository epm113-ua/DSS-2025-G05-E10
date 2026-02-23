<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = ['nutricionista_id', 'nombre', 'preparacion', 'calorias_kcal', 'carbohidratos_g', 'grasas_g', 'ruta_foto'];

    public function nutricionista()
    {
        return $this->belongsTo(Nutricionista::class);
    }

    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'ingrediente_receta');
    }

    public function itemPlans()
    {
        return $this->hasMany(ItemPlan::class);
    }
}
