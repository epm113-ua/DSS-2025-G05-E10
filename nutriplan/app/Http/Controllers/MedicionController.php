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
        if ($ids = $this->pacienteIdsVisibles()) $query->whereIn('paciente_id',$ids);
        if ($request->filled('paciente_id'))  $query->where('paciente_id',$request->paciente_id);
        if ($request->filled('fecha_desde'))  $query->whereDate('fecha_medicion','>=',$request->fecha_desde);
        if ($request->filled('fecha_hasta'))  $query->whereDate('fecha_medicion','<=',$request->fecha_hasta);
        if ($request->filled('buscar')) {
            $query->whereHas('paciente',fn($q)=>$q->where('nombre_completo','like',"%{$request->buscar}%"));
        }
        $orden     = in_array($request->orden,['fecha_medicion','peso_kg','altura_cm','porcentaje_grasa','imc']) ? $request->orden : 'fecha_medicion';
        $dir       = $request->dir === 'asc' ? 'asc' : 'desc';
        $mediciones= $query->orderBy($orden,$dir)->paginate(10)->withQueryString();
        $pacientes = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('mediciones.index', compact('mediciones','orden','dir','pacientes'));
    }

    public function create()
    {
        $pacientes = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('mediciones.form', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'paciente_id'     =>'required|exists:pacientes,id',
            'fecha_medicion'  =>'required|date',
            'peso_kg'         =>'required|numeric|min:1|max:500',
            'altura_cm'       =>'required|integer|min:50|max:250',
            'porcentaje_grasa'=>'nullable|numeric|min:0|max:100',
            'notas'           =>'nullable|string|max:500',
        ]);
        $datos['imc'] = round($datos['peso_kg']/(($datos['altura_cm']/100)**2),2);
        Medicion::create($datos);
        return redirect()->route('mediciones.index')->with('exito','Medición registrada correctamente.');
    }

    public function show(Medicion $medicion) { return view('mediciones.show', compact('medicion')); }

    public function edit(Medicion $medicion)
    {
        $pacientes = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('mediciones.form', compact('medicion','pacientes'));
    }

    public function update(Request $request, Medicion $medicion)
    {
        $datos = $request->validate([
            'paciente_id'     =>'required|exists:pacientes,id',
            'fecha_medicion'  =>'required|date',
            'peso_kg'         =>'required|numeric|min:1|max:500',
            'altura_cm'       =>'required|integer|min:50|max:250',
            'porcentaje_grasa'=>'nullable|numeric|min:0|max:100',
            'notas'           =>'nullable|string|max:500',
        ]);
        $datos['imc'] = round($datos['peso_kg']/(($datos['altura_cm']/100)**2),2);
        $medicion->update($datos);
        return redirect()->route('mediciones.index')->with('exito','Medición actualizada correctamente.');
    }

    public function destroy(Medicion $medicion)
    {
        $medicion->delete();
        return redirect()->route('mediciones.index')->with('exito','Medición eliminada correctamente.');
    }
}
