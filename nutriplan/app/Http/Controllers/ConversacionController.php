<?php

namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Paciente;
use App\Models\Nutricionista;
use App\Models\Cita;
use Illuminate\Http\Request;

class ConversacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Conversacion::with(['paciente', 'nutricionista']);

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('colaboracion', 'like', "%{$term}%")
                  ->orWhere('mensaje_resumen', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'creado_en');
        $dir   = $request->get('dir', 'desc');
        $columnas = ['creado_en', 'colaboracion', 'porcentaje'];
        if (!in_array($orden, $columnas)) $orden = 'creado_en';

        $conversaciones = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('conversaciones.index', compact('conversaciones', 'orden', 'dir'));
    }

    public function create()
    {
        $pacientes      = Paciente::orderBy('nombre_completo')->get();
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        $citas          = Cita::with('paciente')->orderBy('inicio', 'desc')->get();
        return view('conversaciones.form', compact('pacientes', 'nutricionistas', 'citas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'paciente_id'      => 'required|exists:pacientes,id',
            'nutricionista_id' => 'required|exists:nutricionistas,id',
            'cita_id'          => 'required|exists:citas,id',
            'colaboracion'     => 'required|string|max:255',
            'porcentaje'       => 'required|integer|min:0|max:100',
            'mensaje_resumen'  => 'nullable|string|max:500',
            'creado_en'        => 'required|date',
        ]);

        Conversacion::create($datos);

        return redirect()->route('conversaciones.index')->with('exito', 'Conversación creada correctamente.');
    }

    public function edit(Conversacion $conversacion)
    {
        $pacientes      = Paciente::orderBy('nombre_completo')->get();
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        $citas          = Cita::with('paciente')->orderBy('inicio', 'desc')->get();
        return view('conversaciones.form', compact('conversacion', 'pacientes', 'nutricionistas', 'citas'));
    }

    public function update(Request $request, Conversacion $conversacion)
    {
        $datos = $request->validate([
            'paciente_id'      => 'required|exists:pacientes,id',
            'nutricionista_id' => 'required|exists:nutricionistas,id',
            'cita_id'          => 'required|exists:citas,id',
            'colaboracion'     => 'required|string|max:255',
            'porcentaje'       => 'required|integer|min:0|max:100',
            'mensaje_resumen'  => 'nullable|string|max:500',
            'creado_en'        => 'required|date',
        ]);

        $conversacion->update($datos);

        return redirect()->route('conversaciones.index')->with('exito', 'Conversación actualizada correctamente.');
    }

    public function destroy(Conversacion $conversacion)
    {
        $conversacion->delete();
        return redirect()->route('conversaciones.index')->with('exito', 'Conversación eliminada correctamente.');
    }
}
