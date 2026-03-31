<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::with('factura');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('nombre_titular', 'like', "%{$term}%")
                  ->orWhereHas('factura', fn($f) => $f->where('numero_factura', 'like', "%{$term}%"));
            });
        }

        $orden = $request->get('orden', 'fecha_pago');
        $dir   = $request->get('dir', 'desc');
        $columnas = ['fecha_pago', 'nombre_titular'];
        if (!in_array($orden, $columnas)) $orden = 'fecha_pago';

        $pagos = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('pagos.index', compact('pagos', 'orden', 'dir'));
    }

    public function create()
    {
        $facturas = Factura::orderBy('numero_factura')->get();
        return view('pagos.form', compact('facturas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'factura_id'     => 'required|exists:facturas,id',
            'nombre_titular' => 'required|string|max:255',
            'fecha_pago'     => 'required|date',
        ]);

        Pago::create($datos);

        return redirect()->route('pagos.index')->with('exito', 'Pago registrado correctamente.');
    }

    public function edit(Pago $pago)
    {
        $facturas = Factura::orderBy('numero_factura')->get();
        return view('pagos.form', compact('pago', 'facturas'));
    }

    public function update(Request $request, Pago $pago)
    {
        $datos = $request->validate([
            'factura_id'     => 'required|exists:facturas,id',
            'nombre_titular' => 'required|string|max:255',
            'fecha_pago'     => 'required|date',
        ]);

        $pago->update($datos);

        return redirect()->route('pagos.index')->with('exito', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('exito', 'Pago eliminado correctamente.');
    }
}
