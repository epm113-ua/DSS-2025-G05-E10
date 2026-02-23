<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = ['paciente_id', 'numero_factura', 'pagado_en'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
