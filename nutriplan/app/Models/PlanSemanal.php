<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanSemanal extends Model
{
    use HasFactory;
    protected $table = 'plan_semanal';

    protected $fillable = [
        'cita_id',
        'semanal_inicio',
        'notas',
    ];

    protected $casts = [
        'semanal_inicio' => 'date',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function itemPlans()
    {
        return $this->hasMany(ItemPlan::class);
    }
}