<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPlan extends Model
{
    use HasFactory;
    protected $table = 'item_plans';

    protected $fillable = [
        'plan_semanal_id',
        'dia_semana',
        'tipo_comida',
        'notas',
    ];

    public function planSemanal()
    {
        return $this->belongsTo(PlanSemanal::class);
    }
}