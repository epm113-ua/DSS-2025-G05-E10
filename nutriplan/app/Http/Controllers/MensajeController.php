<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Conversacion;
use App\Models\Factura;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    public function index(Request $request)
    {
        $query = Mensaje::with(['conversacion', 'factura']);

        if ($request->filled('buscar')) {
            $query->where('contenido', 'like', '%' . $request->buscar . '%');
        }

        $orden = $request->get('orden', 'enviado_en');
        $dir   = $request->get('dir', 'desc');
        $columnas = ['enviado_en', 'contenido'];
        if (!in_array($orden, $columnas)) $orden = 'enviado_en';

        $mensajes = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('mensajes.index', compact('mensajes', 'orden', 'dir'));
    }

    public function create()
    {
        $conversaciones = Conversacion::with('paciente')->orderBy('creado_en', 'desc')->get();
        $facturas       = Factura::orderBy('numero_factura')->get();
        return view('mensajes.form', compact('conversaciones', 'facturas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'conversacion_id' => 'required|exists:conversaciones,id',
            'factura_id'      => 'nullable|exists:facturas,id',
            'contenido'       => 'required|string|max:1000',
            'enviado_en'      => 'required|date',
        ]);

        Mensaje::create($datos);

        return redirect()->route('mensajes.index')->with('exito', 'Mensaje creado correctamente.');
    }

    public function edit(Mensaje $mensaje)
    {
        $conversaciones = Conversacion::with('paciente')->orderBy('creado_en', 'desc')->get();
        $facturas       = Factura::orderBy('numero_factura')->get();
        return view('mensajes.form', compact('mensaje', 'conversaciones', 'facturas'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        $datos = $request->validate([
            'conversacion_id' => 'required|exists:conversaciones,id',
            'factura_id'      => 'nullable|exists:facturas,id',
            'contenido'       => 'required|string|max:1000',
            'enviado_en'      => 'required|date',
        ]);

        $mensaje->update($datos);

        return redirect()->route('mensajes.index')->with('exito', 'Mensaje actualizado correctamente.');
    }

    public function destroy(Mensaje $mensaje)
    {
        $mensaje->delete();
        return redirect()->route('mensajes.index')->with('exito', 'Mensaje eliminado correctamente.');
    }
}
