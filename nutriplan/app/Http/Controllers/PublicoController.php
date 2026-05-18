<?php

namespace App\Http\Controllers;

use App\Models\Nutricionista;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicoController extends Controller
{
    public function inicio()
    {
        $stats = [
            'nutricionistas' => Nutricionista::count(),
            'pacientes'      => Paciente::count(),
        ];
        return view('publico.inicio', compact('stats'));
    }

    public function sobre()
    {
        return view('publico.sobre');
    }

    public function contacto()
    {
        return view('publico.contacto');
    }

    public function enviarContacto(Request $request)
    {
        $request->validate([
            'nombre'  => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email'],
            'mensaje' => ['required', 'string', 'max:2000'],
        ]);

        // En producción aquí se enviaría un email
        return back()->with('exito', '¡Mensaje enviado! Te responderemos lo antes posible.');
    }
}
