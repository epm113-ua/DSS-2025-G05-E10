<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'paciente_id'      => ['required', 'exists:pacientes,id'],
            'nutricionista_id' => ['required', 'exists:nutricionistas,id'],
            'inicio'           => ['required', 'date', 'after:now'],
            'fin'              => ['required', 'date', 'after:inicio'],
            'motivo'           => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'inicio.after' => 'La fecha de inicio debe ser futura.',
            'fin.after'    => 'La hora de fin debe ser posterior al inicio.',
        ];
    }
}
