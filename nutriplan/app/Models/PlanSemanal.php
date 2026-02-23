<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSemanal extends Model
{
    use HasFactory;

    protected $table = 'plan_semanales';

    protected $fillable = ['cita_id', 'semana_inicio', 'notas'];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function itemPlans()
    {
        return $this->hasMany(ItemPlan::class);
    }
}
