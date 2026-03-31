<?php

namespace App\Http\Controllers;

use App\Models\PlanSemanal;
use App\Models\Cita;
use Illuminate\Http\Request;

class PlanSemanalController extends Controller
{
    public function index(Request $request)
    {
        $query = PlanSemanal::with('cita.paciente');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('notas', 'like', "%{$term}%")
                  ->orWhere('semana_inicio', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'semana_inicio');
        $dir   = $request->get('dir', 'desc');
        if (!in_array($orden, ['semana_inicio', 'notas'])) $orden = 'semana_inicio';

        $planes = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('plan-semanales.index', compact('planes', 'orden', 'dir'));
    }

    public function create()
    {
        $citas = Cita::with('paciente')->orderBy('inicio', 'desc')->get();
        return view('plan-semanales.form', compact('citas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'cita_id'       => 'required|exists:citas,id',
            'semana_inicio' => 'required|date',
            'notas'         => 'nullable|string|max:500',
        ]);

        PlanSemanal::create($datos);

        return redirect()->route('plan-semanales.index')->with('exito', 'Plan semanal creado correctamente.');
    }

    public function edit(PlanSemanal $planSemanal)
    {
        $citas = Cita::with('paciente')->orderBy('inicio', 'desc')->get();
        return view('plan-semanales.form', compact('planSemanal', 'citas'));
    }

    public function update(Request $request, PlanSemanal $planSemanal)
    {
        $datos = $request->validate([
            'cita_id'       => 'required|exists:citas,id',
            'semana_inicio' => 'required|date',
            'notas'         => 'nullable|string|max:500',
        ]);

        $planSemanal->update($datos);

        return redirect()->route('plan-semanales.index')->with('exito', 'Plan semanal actualizado correctamente.');
    }

    public function destroy(PlanSemanal $planSemanal)
    {
        $planSemanal->delete();
        return redirect()->route('plan-semanales.index')->with('exito', 'Plan semanal eliminado correctamente.');
    }
}
