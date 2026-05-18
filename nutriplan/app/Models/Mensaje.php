<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversacion_id', 'factura_id', 'autor_user_id', 'contenido', 'enviado_en',
    ];

    protected function casts(): array
    {
        return ['enviado_en' => 'datetime'];
    }

    public function conversacion() { return $this->belongsTo(Conversacion::class); }
    public function factura()      { return $this->belongsTo(Factura::class); }
    public function autor()        { return $this->belongsTo(User::class, 'autor_user_id'); }
}
