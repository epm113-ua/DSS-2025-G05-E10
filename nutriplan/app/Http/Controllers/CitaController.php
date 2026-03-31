<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $query = Cita::with(['nutricionista', 'paciente']);

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('motivo', 'like', "%{$term}%")
                  ->orWhere('estado', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'inicio');
        $dir   = $request->get('dir', 'desc');
        $columnas = ['inicio', 'fin', 'estado', 'motivo'];
        if (!in_array($orden, $columnas)) $orden = 'inicio';

        $citas = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('citas.index', compact('citas', 'orden', 'dir'));
    }

    public function create()
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        $pacientes      = Paciente::orderBy('nombre_completo')->get();
        return view('citas.form', compact('nutricionistas', 'pacientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nutricionista_id' => 'required|exists:nutricionistas,id',
            'paciente_id'      => 'required|exists:pacientes,id',
            'inicio'           => 'required|date',
            'fin'              => 'required|date|after:inicio',
            'estado'           => 'required|in:pendiente,completada,cancelada',
            'motivo'           => 'required|string|max:255',
        ]);

        Cita::create($datos);

        return redirect()->route('citas.index')->with('exito', 'Cita creada correctamente.');
    }

    public function edit(Cita $cita)
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        $pacientes      = Paciente::orderBy('nombre_completo')->get();
        return view('citas.form', compact('cita', 'nutricionistas', 'pacientes'));
    }

    public function update(Request $request, Cita $cita)
    {
        $datos = $request->validate([
            'nutricionista_id' => 'required|exists:nutricionistas,id',
            'paciente_id'      => 'required|exists:pacientes,id',
            'inicio'           => 'required|date',
            'fin'              => 'required|date|after:inicio',
            'estado'           => 'required|in:pendiente,completada,cancelada',
            'motivo'           => 'required|string|max:255',
        ]);

        $cita->update($datos);

        return redirect()->route('citas.index')->with('exito', 'Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('exito', 'Cita eliminada correctamente.');
    }
}
