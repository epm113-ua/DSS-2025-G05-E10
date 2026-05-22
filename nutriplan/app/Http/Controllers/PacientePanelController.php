<?php
namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\PlanSemanal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PacientePanelController extends Controller
{
    private function paciente() { return Auth::user()->paciente; }

    public function miDia()
    {
        $paciente       = $this->paciente()->load('nutricionista');
        $proximaCita    = $paciente->citas()->where('estado','pendiente')->where('inicio','>=',now())->orderBy('inicio')->first();
        $plan           = PlanSemanal::whereHas('cita',fn($q)=>$q->where('paciente_id',$paciente->id))->where('semana_inicio','<=',now()->toDateString())->orderByDesc('semana_inicio')->first();
        $itemsHoy       = $plan ? $plan->itemPlans()->with('receta')->where('dia_semana',now()->isoWeekday())->get() : collect();
        $ultimaMedicion = $paciente->mediciones()->latest('fecha_medicion')->first();
        return view('paciente.mi-dia', compact('paciente','proximaCita','plan','itemsHoy','ultimaMedicion'));
    }

    public function miPlan()
    {
        $paciente    = $this->paciente();
        $plan        = PlanSemanal::whereHas('cita',fn($q)=>$q->where('paciente_id',$paciente->id))->with(['itemPlans.receta','cita.nutricionista'])->where('semana_inicio','<=',now()->toDateString())->orderByDesc('semana_inicio')->first();
        $itemsPorDia = $plan ? $plan->itemPlans->groupBy('dia_semana') : collect();
        return view('paciente.mi-plan', compact('paciente','plan','itemsPorDia'));
    }

    public function miProgreso()
    {
        $paciente   = $this->paciente();
        $mediciones = $paciente->mediciones()->orderBy('fecha_medicion')->get();
        return view('paciente.mi-progreso', compact('paciente','mediciones'));
    }

    public function misConsultas()
    {
        $paciente = $this->paciente()->load('nutricionista');
        $citas    = $paciente->citas()->with('nutricionista')->orderByDesc('inicio')->paginate(10);
        return view('paciente.mis-consultas', compact('paciente','citas'));
    }

    public function misFacturas()
    {
        $paciente = $this->paciente();
        $facturas = $paciente->facturas()->with('pagos')->orderByDesc('created_at')->paginate(10);
        return view('paciente.mis-facturas', compact('paciente','facturas'));
    }

    public function miPerfil()
    {
        $paciente = $this->paciente()->load('nutricionista');
        return view('paciente.mi-perfil', compact('paciente'));
    }

    /** Usa POST (no PATCH) para compatibilidad con enctype multipart */
    public function actualizarPerfil(Request $request)
    {
        $paciente  = $this->paciente();
        $validated = $request->validate([
            'fecha_nacimiento' => ['nullable','date','before:today'],
            'ciudad'           => ['nullable','string','max:100'],
            'objetivos'        => ['nullable','string','max:500'],
            'foto'             => ['nullable','image','max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($paciente->foto) Storage::disk('public')->delete($paciente->foto);
            $validated['foto'] = $request->file('foto')->store('fotos','public');
        } else {
            // No sobrescribir foto si no se envía
            unset($validated['foto']);
        }

        $paciente->update($validated);

        if ($request->filled('name')) {
            Auth::user()->update(['name' => $request->input('name')]);
            $paciente->update(['nombre_completo' => $request->input('name')]);
        }

        return back()->with('exito','Perfil actualizado correctamente.');
    }

    public function solicitarCita(Request $request)
    {
        $paciente  = $this->paciente();
        $validated = $request->validate(['inicio'=>['required','date','after:now'],'motivo'=>['nullable','string','max:500']]);
        \App\Models\Cita::create([
            'paciente_id'      => $paciente->id,
            'nutricionista_id' => $paciente->nutricionista_id,
            'inicio'           => $validated['inicio'],
            'fin'              => Carbon::parse($validated['inicio'])->addHour(),
            'estado'           => 'pendiente',
            'motivo'           => $validated['motivo'] ?? 'Solicitud del paciente',
        ]);
        return back()->with('exito','Cita solicitada. Tu nutricionista la confirmará pronto.');
    }

    public function misMensajes()
    {
        $paciente = $this->paciente()->load('nutricionista');

        // Conversación compartida con su nutricionista (la más reciente con ese nutri)
        $conversacion = Conversacion::where('paciente_id', $paciente->id)
            ->when($paciente->nutricionista_id, fn($q) => $q->where('nutricionista_id', $paciente->nutricionista_id))
            ->latest('updated_at')
            ->first();

        $mensajes = $conversacion
            ? $conversacion->mensajes()->with('autor')->orderBy('enviado_en')->orderBy('created_at')->get()
            : collect();

        return view('paciente.mis-mensajes', compact('paciente','conversacion','mensajes'));
    }
}
