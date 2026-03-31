<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Paciente;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with('paciente');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('numero_factura', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'numero_factura');
        $dir   = $request->get('dir', 'asc');
        $columnas = ['numero_factura', 'pagado_en'];
        if (!in_array($orden, $columnas)) $orden = 'numero_factura';

        $facturas = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('facturas.index', compact('facturas', 'orden', 'dir'));
    }

    public function create()
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        return view('facturas.form', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'paciente_id'    => 'required|exists:pacientes,id',
            'numero_factura' => 'required|string|max:50|unique:facturas,numero_factura',
            'pagado_en'      => 'nullable|date',
        ]);

        Factura::create($datos);

        return redirect()->route('facturas.index')->with('exito', 'Factura creada correctamente.');
    }

    public function edit(Factura $factura)
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        return view('facturas.form', compact('factura', 'pacientes'));
    }

    public function update(Request $request, Factura $factura)
    {
        $datos = $request->validate([
            'paciente_id'    => 'required|exists:pacientes,id',
            'numero_factura' => 'required|string|max:50|unique:facturas,numero_factura,' . $factura->id,
            'pagado_en'      => 'nullable|date',
        ]);

        $factura->update($datos);

        return redirect()->route('facturas.index')->with('exito', 'Factura actualizada correctamente.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('exito', 'Factura eliminada correctamente.');
    }
}
