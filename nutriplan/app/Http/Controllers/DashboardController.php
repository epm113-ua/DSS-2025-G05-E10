<?php
namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Admin va directo al panel de administración
        if ($user->esAdmin()) {
            return redirect()->route('admin.index');
        }
        // Nutricionista
        $nutricionista = $user->nutricionista;
        $stats = [
            'mis_pacientes'    => $nutricionista ? $nutricionista->pacientes()->count() : 0,
            'citas_hoy'        => $nutricionista ? Cita::where('nutricionista_id',$nutricionista->id)->whereDate('inicio',today())->count() : 0,
            'citas_pendientes' => $nutricionista ? Cita::where('nutricionista_id',$nutricionista->id)->where('estado','pendiente')->where('inicio','>=',now())->count() : 0,
        ];
        return view('dashboard', compact('user','stats','nutricionista'));
    }
}
