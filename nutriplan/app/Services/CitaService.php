<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Nutricionista;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CitaService
{
    public function programarCita(
        Paciente $paciente,
        Nutricionista $nutricionista,
        Carbon $inicio,
        Carbon $fin,
        string $motivo
    ): Cita {
        if ($paciente->nutricionista_id !== $nutricionista->id) {
            throw new \InvalidArgumentException(
                "El paciente [{$paciente->id}] no pertenece al nutricionista [{$nutricionista->id}]."
            );
        }

        $solapamiento = Cita::where('nutricionista_id', $nutricionista->id)
            ->where('estado', '!=', 'CANCELLED')
            ->where(function ($query) use ($inicio, $fin) {
                $query->whereBetween('inicio', [$inicio, $fin])
                      ->orWhereBetween('fin', [$inicio, $fin])
                      ->orWhere(function ($q) use ($inicio, $fin) {
                          $q->where('inicio', '<=', $inicio)
                            ->where('fin', '>=', $fin);
                      });
            })
            ->exists();

        if ($solapamiento) {
            throw new \RuntimeException(
                "El nutricionista ya tiene una cita en ese rango horario."
            );
        }

        return Cita::create([
            'nutricionista_id' => $nutricionista->id,
            'paciente_id' => $paciente->id,
            'inicio' => $inicio,
            'fin' => $fin,
            'estado' => 'SCHEDULED',
            'motivo' => $motivo,
        ]);
    }

    public function cancelarCita(Cita $cita): Cita
    {
        if ($cita->estado === 'DONE') {
            throw new \RuntimeException("No se puede cancelar una cita ya completada.");
        }

        $cita->update(['estado' => 'CANCELLED']);

        return $cita->fresh();
    }

    public function citasProximasDe(Nutricionista $nutricionista): Collection
    {
        return $nutricionista->citas()
            ->with('paciente')
            ->where('estado', 'SCHEDULED')
            ->where('inicio', '>=', now())
            ->orderBy('inicio')
            ->get();
    }
}
