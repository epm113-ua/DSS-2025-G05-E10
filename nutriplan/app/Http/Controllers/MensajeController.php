<?php
namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Mensaje;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    /**
     * Bandeja de chat del nutricionista (y admin).
     * Muestra la lista de pacientes a la izquierda y el hilo de mensajes
     * de la conversacion seleccionada a la derecha. Permite elegir con
     * que paciente hablar; si no existe conversacion, se crea al abrirla.
     */
    public function chat(Request $request)
    {
        $nid = $this->nutricionistaId();

        // Pacientes que puede ver: los asignados al nutricionista (o todos si es admin)
        $pacientes = Paciente::query()
            ->when($nid, fn($q) => $q->where('nutricionista_id', $nid))
            ->orderBy('nombre_completo')
            ->get();

        // Conversaciones existentes indexadas por paciente_id para el sidebar
        $conversaciones = Conversacion::query()
            ->when($nid, fn($q) => $q->where('nutricionista_id', $nid))
            ->with('paciente')
            ->orderByDesc('updated_at')
            ->get();
        $convPorPaciente = $conversaciones->keyBy('paciente_id');

        // Determinar el paciente activo (por query string o el primero con conversacion)
        $pacienteActivo = null;
        if ($request->filled('paciente')) {
            $pacienteActivo = $pacientes->firstWhere('id', (int) $request->paciente);
        }
        if (!$pacienteActivo) {
            $pacienteActivo = $pacientes->first(fn($p) => $convPorPaciente->has($p->id))
                ?? $pacientes->first();
        }

        $conversacion = null;
        $mensajes     = collect();

        if ($pacienteActivo) {
            $conversacion = $this->obtenerOCrearConversacion($pacienteActivo);
            $mensajes = $conversacion->mensajes()
                ->with('autor')
                ->orderBy('enviado_en')
                ->orderBy('created_at')
                ->get();
        }

        return view('mensajes.chat', compact(
            'pacientes', 'convPorPaciente', 'pacienteActivo', 'conversacion', 'mensajes'
        ));
    }

    /**
     * Devuelve la conversacion del paciente con su nutricionista,
     * creandola si todavia no existe (chat directo sin cita).
     */
    private function obtenerOCrearConversacion(Paciente $paciente): Conversacion
    {
        $nid = $this->nutricionistaId() ?? $paciente->nutricionista_id;

        $conversacion = Conversacion::where('paciente_id', $paciente->id)
            ->when($nid, fn($q) => $q->where('nutricionista_id', $nid))
            ->latest('updated_at')
            ->first();

        if (!$conversacion) {
            $conversacion = Conversacion::create([
                'paciente_id'      => $paciente->id,
                'nutricionista_id' => $nid ?? $paciente->nutricionista_id,
                'cita_id'          => null,
                'colaboracion'     => 'Conversacion directa',
                'porcentaje'       => 0,
                'mensaje_resumen'  => null,
                'creado_en'        => now(),
            ]);
        }

        return $conversacion;
    }

    public function index(Request $request)
    {
        // El nutricionista usa la bandeja de chat
        return $this->chat($request);
    }

    public function create()
    {
        $conversaciones = Conversacion::with('paciente')->orderBy('created_at', 'desc')->get();
        return view('mensajes.form', compact('conversaciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conversacion_id' => ['nullable', 'exists:conversaciones,id'],
            'paciente_id'     => ['nullable', 'exists:pacientes,id'],
            'contenido'       => ['required', 'string', 'max:2000'],
        ]);

        $conversacion = null;

        // Si quien envía es paciente, forzamos su propia conversación (seguridad)
        if (Auth::user()->esPaciente()) {
            $paciente = Auth::user()->paciente;
            if ($paciente) {
                $conversacion = $this->obtenerOCrearConversacion($paciente);
            }
        } elseif (!empty($validated['conversacion_id'])) {
            $conversacion = Conversacion::find($validated['conversacion_id']);
        } elseif (!empty($validated['paciente_id'])) {
            $paciente = Paciente::find($validated['paciente_id']);
            if ($paciente) {
                $conversacion = $this->obtenerOCrearConversacion($paciente);
            }
        }

        if (!$conversacion) {
            return back()->with('error', 'No se pudo determinar la conversacion.');
        }

        Mensaje::create([
            'conversacion_id' => $conversacion->id,
            'contenido'       => $validated['contenido'],
            'autor_user_id'   => Auth::id(),
            'enviado_en'      => now(),
        ]);

        // Marcar la conversacion como actualizada para ordenarla arriba
        $conversacion->touch();

        if (Auth::user()->esPaciente()) {
            return redirect()->route('paciente.mis-mensajes')->with('exito', 'Mensaje enviado.');
        }

        return redirect()
            ->route('mensajes.chat', ['paciente' => $conversacion->paciente_id])
            ->with('exito', 'Mensaje enviado.');
    }

    public function show(Mensaje $mensaje) { return view('mensajes.show', compact('mensaje')); }

    public function edit(Mensaje $mensaje)
    {
        $conversaciones = Conversacion::with('paciente')->get();
        return view('mensajes.form', compact('mensaje', 'conversaciones'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        $mensaje->update($request->validate(['contenido' => ['required', 'string', 'max:2000']]));
        return back()->with('exito', 'Mensaje actualizado.');
    }

    public function destroy(Mensaje $mensaje)
    {
        $pacienteId = $mensaje->conversacion?->paciente_id;
        $mensaje->delete();

        if (Auth::user()->esPaciente()) {
            return redirect()->route('paciente.mis-mensajes')->with('exito', 'Mensaje eliminado.');
        }
        return redirect()->route('mensajes.chat', ['paciente' => $pacienteId])->with('exito', 'Mensaje eliminado.');
    }
}
