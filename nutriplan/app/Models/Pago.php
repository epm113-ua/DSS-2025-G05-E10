<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = ['factura_id', 'nombre_titular', 'fecha_pago'];

    protected $casts = [
        'fecha_pago' => 'datetime',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
