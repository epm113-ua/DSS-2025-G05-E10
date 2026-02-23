<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_factura',
        'pagado_en',
    ];

    protected $casts = [
        'pagado_en' => 'datetime',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}