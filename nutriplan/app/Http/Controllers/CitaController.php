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
        $query = Cita::with(['nutricionista','paciente']);
        if ($nid = $this->nutricionistaId()) $query->where('nutricionista_id', $nid);
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('motivo','like',"%{$request->buscar}%")->orWhere('estado','like',"%{$request->buscar}%");
            });
        }
        if ($request->filled('paciente_id')) $query->where('paciente_id',$request->paciente_id);
        if ($request->filled('estado'))      $query->where('estado',$request->estado);
        $orden = in_array($request->orden,['inicio','fin','estado','motivo']) ? $request->orden : 'inicio';
        $dir   = $request->dir === 'asc' ? 'asc' : 'desc';
        $citas    = $query->orderBy($orden,$dir)->paginate(10)->withQueryString();
        $pacientes= $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('citas.index', compact('citas','orden','dir','pacientes'));
    }

    public function create()
    {
        $nid = $this->nutricionistaId();
        $nutricionistas = $nid
            ? Nutricionista::where('id',$nid)->get()
            : Nutricionista::orderBy('nombre_completo')->get();
        $pacientes = $nid
            ? Paciente::where('nutricionista_id',$nid)->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('citas.form', compact('nutricionistas','pacientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nutricionista_id'=>'required|exists:nutricionistas,id',
            'paciente_id'     =>'required|exists:pacientes,id',
            'inicio'          =>'required|date',
            'fin'             =>'required|date|after:inicio',
            'estado'          =>'required|in:pendiente,completada,cancelada',
            'motivo'          =>'required|string|max:255',
        ]);
        Cita::create($datos);
        return redirect()->route('citas.index')->with('exito','Cita creada correctamente.');
    }

    public function show(Cita $cita) { return view('citas.show', compact('cita')); }

    public function edit(Cita $cita)
    {
        $nid = $this->nutricionistaId();
        $nutricionistas = $nid ? Nutricionista::where('id',$nid)->get() : Nutricionista::orderBy('nombre_completo')->get();
        $pacientes      = $nid ? Paciente::where('nutricionista_id',$nid)->orderBy('nombre_completo')->get() : Paciente::orderBy('nombre_completo')->get();
        return view('citas.form', compact('cita','nutricionistas','pacientes'));
    }

    public function update(Request $request, Cita $cita)
    {
        $datos = $request->validate([
            'nutricionista_id'=>'required|exists:nutricionistas,id',
            'paciente_id'     =>'required|exists:pacientes,id',
            'inicio'          =>'required|date',
            'fin'             =>'required|date|after:inicio',
            'estado'          =>'required|in:pendiente,completada,cancelada',
            'motivo'          =>'required|string|max:255',
        ]);
        $cita->update($datos);
        return redirect()->route('citas.index')->with('exito','Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('exito','Cita eliminada correctamente.');
    }
}
