<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mensaje extends Model
{
    use HasFactory;
    protected $fillable = [
        'conversacion_id',
        'contenido',
        'factura_id',
        'enviado_en',
    ];

    protected $casts = [
        'enviado_en' => 'datetime',
    ];

    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class);
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}