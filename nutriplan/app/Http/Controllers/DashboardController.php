<?php

namespace App\Http\Controllers;

use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Receta;
use App\Models\Medicion;
use App\Models\Factura;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!User::modoAdmin()) {
            return redirect()->route('nutricionistas.index');
        }

        $usuarioActual = User::currentUser();

        $stats = [
            'nutricionistas' => Nutricionista::count(),
            'pacientes' => Paciente::count(),
            'citas' => Cita::count(),
            'recetas' => Receta::count(),
            'mediciones' => Medicion::count(),
            'facturas_pendientes' => Factura::whereNull('pagado_en')->count(),
        ];

        $citasRecientes = Cita::with(['paciente', 'nutricionista'])
            ->orderByDesc('inicio')
            ->limit(5)
            ->get();

        $medidasRecientes = Medicion::with('paciente')
            ->orderByDesc('fecha_medicion')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'usuarioActual', 'stats', 'citasRecientes', 'medidasRecientes'
        ));
    }

    public function cambiarModo(Request $request)
    {
        $modoActual = session('modo_admin', true);
        session(['modo_admin' => !$modoActual]);

        if ($modoActual) {
            return redirect()->route('nutricionistas.index');
        }

        return redirect()->route('dashboard');
    }
}
