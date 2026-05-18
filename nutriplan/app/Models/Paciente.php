<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Paciente extends Model {
    use HasFactory;
    protected $fillable = ['user_id','nutricionista_id','nombre_completo','fecha_nacimiento','ciudad','objetivos','foto'];
    protected $casts = ['fecha_nacimiento' => 'date'];
    public function user()          { return $this->belongsTo(User::class); }
    public function nutricionista() { return $this->belongsTo(Nutricionista::class); }
    public function mediciones()    { return $this->hasMany(Medicion::class); }
    public function citas()         { return $this->hasMany(Cita::class); }
    public function conversaciones(){ return $this->hasMany(Conversacion::class); }
    public function facturas()      { return $this->hasMany(Factura::class); }
    public function edad(): ?int    { return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null; }
    public function ultimaMedicion(): ?Medicion { return $this->mediciones()->latest('fecha_medicion')->first(); }
    public function perfilCompleto(): bool { return filled($this->fecha_nacimiento) && filled($this->ciudad) && filled($this->objetivos); }
}
