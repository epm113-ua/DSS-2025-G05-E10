<?php
namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    public function index(Request $request)
    {
        $query = Mensaje::with(['conversacion.paciente','autor'])->latest();
        if ($request->filled('conversacion_id')) $query->where('conversacion_id',$request->conversacion_id);
        $mensajes = $query->paginate(20)->withQueryString();
        return view('mensajes.index', compact('mensajes'));
    }

    public function create()
    {
        $conversaciones = Conversacion::with('paciente')->orderBy('created_at','desc')->get();
        return view('mensajes.form', compact('conversaciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conversacion_id' => ['required','exists:conversaciones,id'],
            'contenido'       => ['required','string','max:2000'],
        ]);

        Mensaje::create([
            'conversacion_id' => $validated['conversacion_id'],
            'contenido'       => $validated['contenido'],
            'autor_user_id'   => Auth::id(),
            'enviado_en'      => now(),
        ]);

        // Actualizar timestamp de la conversación para ordenar en sidebar
        Conversacion::where('id', $validated['conversacion_id'])->touch();

        // Redirigir según rol
        if (Auth::user()->esPaciente()) {
            return redirect()->route('paciente.mis-mensajes')->with('exito','Mensaje enviado.');
        }
        return redirect()->route('conversaciones.show', $validated['conversacion_id'])->with('exito','Mensaje enviado.');
    }

    public function show(Mensaje $mensaje) { return view('mensajes.show', compact('mensaje')); }

    public function edit(Mensaje $mensaje)
    {
        $conversaciones = Conversacion::with('paciente')->get();
        return view('mensajes.form', compact('mensaje','conversaciones'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        $mensaje->update($request->validate(['contenido'=>['required','string','max:2000']]));
        return back()->with('exito','Mensaje actualizado.');
    }

    public function destroy(Mensaje $mensaje)
    {
        $convId = $mensaje->conversacion_id;
        $mensaje->delete();
        return redirect()->route('conversaciones.show',$convId)->with('exito','Mensaje eliminado.');
    }
}
