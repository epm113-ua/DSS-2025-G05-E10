<?php
namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Conversacion;
use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Conversacion::with(['paciente','nutricionista'])->latest('updated_at');

        if ($nid = $this->nutricionistaId())
            $query->where('nutricionista_id', $nid);

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function($q) use ($term){
                $q->where('colaboracion','like',"%{$term}%")
                  ->orWhereHas('paciente',fn($p)=>$p->where('nombre_completo','like',"%{$term}%"));
            });
        }
        if ($request->filled('paciente_id'))
            $query->where('paciente_id', $request->paciente_id);

        $orden = in_array($request->orden,['creado_en','colaboracion']) ? $request->orden : 'creado_en';
        $dir   = $request->dir === 'asc' ? 'asc' : 'desc';

        $conversaciones = $query->orderBy($orden,$dir)->paginate(15)->withQueryString();
        $pacientes = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();

        return view('conversaciones.index', compact('conversaciones','pacientes','orden','dir'));
    }

    public function create()
    {
        $pacientes      = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        $nutricionistas = $this->nutricionistaId()
            ? Nutricionista::where('id',$this->nutricionistaId())->get()
            : Nutricionista::orderBy('nombre_completo')->get();
        $citas = $this->nutricionistaId()
            ? Cita::where('nutricionista_id',$this->nutricionistaId())->with('paciente')->orderBy('inicio','desc')->get()
            : Cita::with('paciente')->orderBy('inicio','desc')->get();
        return view('conversaciones.form', compact('pacientes','nutricionistas','citas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id'      => ['required','exists:pacientes,id'],
            'nutricionista_id' => ['required','exists:nutricionistas,id'],
            'cita_id'          => ['required','exists:citas,id'],
            'colaboracion'     => ['required','string','max:255'],
            'porcentaje'       => ['required','integer','min:0','max:100'],
            'mensaje_resumen'  => ['nullable','string','max:500'],
            'creado_en'        => ['required','date'],
        ]);
        $c = Conversacion::create($validated);
        return redirect()->route('conversaciones.show',$c)->with('exito','Conversación creada.');
    }

    public function show(Conversacion $conversacion)
    {
        $mensajes = $conversacion->mensajes()
            ->with('autor')
            ->orderBy('enviado_en')
            ->orderBy('created_at')
            ->get();

        // Conversaciones del sidebar filtradas por nutricionista
        $conversaciones = Conversacion::with('paciente')
            ->when($this->nutricionistaId(), fn($q,$nid) => $q->where('nutricionista_id',$nid))
            ->orderByDesc('updated_at')
            ->get();

        return view('conversaciones.show', compact('conversacion','mensajes','conversaciones'));
    }

    public function edit(Conversacion $conversacion)
    {
        $pacientes      = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        $nutricionistas = $this->nutricionistaId()
            ? Nutricionista::where('id',$this->nutricionistaId())->get()
            : Nutricionista::orderBy('nombre_completo')->get();
        $citas = Cita::with('paciente')->orderBy('inicio','desc')->get();
        return view('conversaciones.form', compact('conversacion','pacientes','nutricionistas','citas'));
    }

    public function update(Request $request, Conversacion $conversacion)
    {
        $validated = $request->validate([
            'paciente_id'      => ['required','exists:pacientes,id'],
            'nutricionista_id' => ['required','exists:nutricionistas,id'],
            'cita_id'          => ['required','exists:citas,id'],
            'colaboracion'     => ['required','string','max:255'],
            'porcentaje'       => ['required','integer','min:0','max:100'],
            'mensaje_resumen'  => ['nullable','string','max:500'],
            'creado_en'        => ['required','date'],
        ]);
        $conversacion->update($validated);
        return back()->with('exito','Conversación actualizada.');
    }

    public function destroy(Conversacion $conversacion)
    {
        $conversacion->delete();
        return redirect()->route('conversaciones.index')->with('exito','Conversación eliminada.');
    }
}
