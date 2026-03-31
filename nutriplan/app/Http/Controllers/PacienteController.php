<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Nutricionista;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::with('nutricionista');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('nombre_completo', 'like', "%{$term}%")
                  ->orWhere('ciudad', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'nombre_completo');
        $dir   = $request->get('dir', 'asc');
        $columnas = ['nombre_completo', 'ciudad', 'fecha_nacimiento'];
        if (!in_array($orden, $columnas)) $orden = 'nombre_completo';

        $pacientes = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('pacientes.index', compact('pacientes', 'orden', 'dir'));
    }

    public function create()
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        return view('pacientes.form', compact('nutricionistas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nutricionista_id' => 'required|exists:nutricionistas,id',
            'nombre_completo'  => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'ciudad'           => 'required|string|max:255',
            'objetivos'        => 'required|string',
        ]);

        Paciente::create($datos);

        return redirect()->route('pacientes.index')->with('exito', 'Paciente creado correctamente.');
    }

    public function edit(Paciente $paciente)
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        return view('pacientes.form', compact('paciente', 'nutricionistas'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $datos = $request->validate([
            'nutricionista_id' => 'required|exists:nutricionistas,id',
            'nombre_completo'  => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'ciudad'           => 'required|string|max:255',
            'objetivos'        => 'required|string',
        ]);

        $paciente->update($datos);

        return redirect()->route('pacientes.index')->with('exito', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('exito', 'Paciente eliminado correctamente.');
    }
}
