<?php
namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\PlanSemanal;
use Illuminate\Http\Request;

class PlanSemanalController extends Controller
{
    public function index(Request $request)
    {
        $query = PlanSemanal::with('cita.paciente');
        if ($nid = $this->nutricionistaId()) {
            $query->whereHas('cita',fn($q)=>$q->where('nutricionista_id',$nid));
        }
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('notas','like',"%{$request->buscar}%")->orWhere('semana_inicio','like',"%{$request->buscar}%");
            });
        }
        $orden  = in_array($request->orden,['semana_inicio','notas']) ? $request->orden : 'semana_inicio';
        $dir    = $request->dir === 'asc' ? 'asc' : 'desc';
        $planes = $query->orderBy($orden,$dir)->paginate(10)->withQueryString();
        return view('plan-semanales.index', compact('planes','orden','dir'));
    }

    public function create()
    {
        $citas = $this->nutricionistaId()
            ? Cita::where('nutricionista_id',$this->nutricionistaId())->with('paciente')->orderBy('inicio','desc')->get()
            : Cita::with('paciente')->orderBy('inicio','desc')->get();
        return view('plan-semanales.form', compact('citas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'cita_id'      =>'required|exists:citas,id',
            'semana_inicio'=>'required|date',
            'notas'        =>'nullable|string|max:500',
        ]);
        PlanSemanal::create($datos);
        return redirect()->route('plan-semanales.index')->with('exito','Plan semanal creado correctamente.');
    }

    public function edit(PlanSemanal $planSemanal)
    {
        $citas = $this->nutricionistaId()
            ? Cita::where('nutricionista_id',$this->nutricionistaId())->with('paciente')->orderBy('inicio','desc')->get()
            : Cita::with('paciente')->orderBy('inicio','desc')->get();
        return view('plan-semanales.form', compact('planSemanal','citas'));
    }

    public function update(Request $request, PlanSemanal $planSemanal)
    {
        $datos = $request->validate([
            'cita_id'      =>'required|exists:citas,id',
            'semana_inicio'=>'required|date',
            'notas'        =>'nullable|string|max:500',
        ]);
        $planSemanal->update($datos);
        return redirect()->route('plan-semanales.index')->with('exito','Plan semanal actualizado correctamente.');
    }

    public function destroy(PlanSemanal $planSemanal)
    {
        $planSemanal->delete();
        return redirect()->route('plan-semanales.index')->with('exito','Plan semanal eliminado correctamente.');
    }
}
