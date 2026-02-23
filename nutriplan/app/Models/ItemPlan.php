<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPlan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_semanal_id', 'receta_id', 'dia_semana', 'tipo_comida', 'notas'];

    public function planSemanal()
    {
        return $this->belongsTo(PlanSemanal::class);
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }
}
