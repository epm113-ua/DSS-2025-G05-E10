<?php
namespace App\Http\Controllers;
use App\Models\Paciente;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /** ID del nutricionista logueado, o null si es admin */
    protected function nutricionistaId(): ?int
    {
        if (auth()->check() && auth()->user()->esNutricionista()) {
            return auth()->user()->nutricionista?->id;
        }
        return null;
    }

    /** IDs de pacientes visibles según rol */
    protected function pacienteIdsVisibles(): ?array
    {
        if ($nid = $this->nutricionistaId()) {
            return Paciente::where('nutricionista_id', $nid)->pluck('id')->toArray();
        }
        return null; // admin ve todos
    }
}
