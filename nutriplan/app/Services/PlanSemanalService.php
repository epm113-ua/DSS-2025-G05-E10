<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\ItemPlan;
use App\Models\PlanSemanal;
use App\Models\Receta;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PlanSemanalService
{
    public function crearPlan(Cita $cita, string $semanaInicio, array $items, ?string $notas = null): PlanSemanal
    {
        if ($cita->estado !== 'DONE' && $cita->estado !== 'SCHEDULED') {
            throw new \RuntimeException("Solo se puede crear un plan para citas activas o completadas.");
        }

        $recetaIds = collect($items)->pluck('receta_id')->unique();
        $recetasValidas = Receta::whereIn('id', $recetaIds)
            ->where('nutricionista_id', $cita->nutricionista_id)
            ->pluck('id');

        $invalidas = $recetaIds->diff($recetasValidas);
        if ($invalidas->isNotEmpty()) {
            throw new \InvalidArgumentException(
                "Las siguientes recetas no pertenecen al nutricionista de la cita: " . $invalidas->implode(', ')
            );
        }

        $plan = PlanSemanal::create([
            'cita_id' => $cita->id,
            'semana_inicio' => $semanaInicio,
            'notas' => $notas,
        ]);

        foreach ($items as $item) {
            ItemPlan::create([
                'plan_semanal_id' => $plan->id,
                'receta_id' => $item['receta_id'],
                'dia_semana' => $item['dia_semana'],
                'tipo_comida' => $item['tipo_comida'],
                'notas' => $item['notas'] ?? null,
            ]);
        }

        return $plan->load('itemPlans');
    }

    public function planesActivosDePaciente(int $pacienteId): Collection
    {
        return PlanSemanal::whereHas('cita', function ($q) use ($pacienteId) {
                $q->where('paciente_id', $pacienteId);
            })
            ->with(['itemPlans.receta', 'cita'])
            ->where('semana_inicio', '>=', Carbon::now()->startOfWeek()->toDateString())
            ->orderBy('semana_inicio')
            ->get();
    }
}
