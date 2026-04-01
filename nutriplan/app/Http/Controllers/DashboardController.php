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
        $usuarioActual = User::currentUser();
        $esAdmin       = User::modoAdmin();

        // Datos comunes a ambos modos
        $citasRecientes = Cita::with(['paciente', 'nutricionista'])
            ->orderByDesc('inicio')
            ->limit(5)
            ->get();

        $medidasRecientes = Medicion::with('paciente')
            ->orderByDesc('fecha_medicion')
            ->limit(5)
            ->get();

        // Estadísticas solo para el modo admin
        $stats = $esAdmin ? [
            'nutricionistas'      => Nutricionista::count(),
            'pacientes'           => Paciente::count(),
            'citas'               => Cita::count(),
            'recetas'             => Receta::count(),
            'mediciones'          => Medicion::count(),
            'facturas_pendientes' => Factura::whereNull('pagado_en')->count(),
        ] : [];

        return view('dashboard', compact(
            'usuarioActual', 'esAdmin', 'stats', 'citasRecientes', 'medidasRecientes'
        ));
    }

    /**
     * Cambia entre modo admin y modo usuario normal (usando sesión).
     */
    public function cambiarModo(Request $request)
    {
        $modoActual = session('modo_admin', true);
        session(['modo_admin' => !$modoActual]);

        return redirect()->route('dashboard');
    }
}
