<?php

namespace App\Http\Controllers;

use App\Models\Medicion;
use App\Models\Paciente;
use Illuminate\Http\Request;

class MedicionController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicion::with('paciente');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->whereHas('paciente', fn($q) => $q->where('nombre_completo', 'like', "%{$term}%"));
        }

        $orden = $request->get('orden', 'fecha_medicion');
        $dir   = $request->get('dir', 'desc');
        $columnas = ['fecha_medicion', 'peso_kg', 'altura_cm', 'porcentaje_grasa'];
        if (!in_array($orden, $columnas)) $orden = 'fecha_medicion';

        $mediciones = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('mediciones.index', compact('mediciones', 'orden', 'dir'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        return view('mediciones.form', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'paciente_id'       => 'required|exists:pacientes,id',
            'fecha_medicion'    => 'required|date',
            'peso_kg'           => 'required|numeric|min:1|max:500',
            'altura_cm'         => 'required|integer|min:50|max:250',
            'porcentaje_grasa'  => 'nullable|numeric|min:0|max:100',
        ]);

        Medicion::create($datos);

        return redirect()->route('mediciones.index')->with('exito', 'Medición registrada correctamente.');
    }

    public function edit(Medicion $medicion)
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        return view('mediciones.form', compact('medicion', 'pacientes'));
    }

    public function update(Request $request, Medicion $medicion)
    {
        $datos = $request->validate([
            'paciente_id'       => 'required|exists:pacientes,id',
            'fecha_medicion'    => 'required|date',
            'peso_kg'           => 'required|numeric|min:1|max:500',
            'altura_cm'         => 'required|integer|min:50|max:250',
            'porcentaje_grasa'  => 'nullable|numeric|min:0|max:100',
        ]);

        $medicion->update($datos);

        return redirect()->route('mediciones.index')->with('exito', 'Medición actualizada correctamente.');
    }

    public function destroy(Medicion $medicion)
    {
        $medicion->delete();
        return redirect()->route('mediciones.index')->with('exito', 'Medición eliminada correctamente.');
    }
}
