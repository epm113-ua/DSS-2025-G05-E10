<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Receta;
use App\Models\Factura;
use App\Models\Pago;
use App\Models\Tienda;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function verificarAdmin(): void
    {
        if (!User::currentUser()->esAdmin()) {
            abort(403, 'Acceso restringido al panel de administración.');
        }
    }

    public function index()
    {
        $this->verificarAdmin();

        $resumen = [
            'nutricionistas'      => Nutricionista::count(),
            'pacientes'           => Paciente::count(),
            'citas_pendientes'    => Cita::where('estado', 'pendiente')->count(),
            'citas_completadas'   => Cita::where('estado', 'completada')->count(),
            'recetas'             => Receta::count(),
            'tiendas'             => Tienda::count(),
            'ingredientes'        => Ingrediente::count(),
            'facturas_pendientes' => Factura::whereNull('pagado_en')->count(),
            'facturas_pagadas'    => Factura::whereNotNull('pagado_en')->count(),
            'pagos'               => Pago::count(),
        ];

        $nutricionistasTop = Nutricionista::withCount('pacientes')
            ->orderByDesc('pacientes_count')
            ->limit(5)
            ->get();

        $citasRecientes = Cita::with(['paciente', 'nutricionista'])
            ->orderByDesc('inicio')
            ->limit(8)
            ->get();

        $usuario = User::currentUser();

        return view('admin.index', compact('resumen', 'nutricionistasTop', 'citasRecientes', 'usuario'));
    }

    public function usuarios()
    {
        $this->verificarAdmin();
        $usuarios = User::orderBy('name')->paginate(10);
        return view('admin.usuarios', compact('usuarios'));
    }

    public function toggleAdmin(Request $request, User $user)
    {
        $this->verificarAdmin();
        $user->update(['is_admin' => !$user->is_admin]);
        $estado = $user->is_admin ? 'administrador' : 'usuario estándar';
        return redirect()->route('admin.usuarios')
                         ->with('exito', "El usuario \"{$user->name}\" ahora es {$estado}.");
    }
}
