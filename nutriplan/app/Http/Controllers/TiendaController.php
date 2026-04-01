<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Tienda::withCount(['nutricionistas', 'ingredientes', 'ofertas']);

        if ($request->filled('buscar')) {
            $query->where('nombre_tienda', 'like', '%' . $request->buscar . '%');
        }

        $orden = $request->get('orden', 'nombre_tienda');
        $dir   = $request->get('dir', 'asc');
        $columnas = ['nombre_tienda', 'nutricionistas_count', 'ingredientes_count', 'ofertas_count'];
        if (!in_array($orden, $columnas)) $orden = 'nombre_tienda';

        $tiendas = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('tiendas.index', compact('tiendas', 'orden', 'dir'));
    }

    public function create()
    {
        return view('tiendas.form');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_tienda' => 'required|string|max:255|unique:tiendas,nombre_tienda',
        ]);

        Tienda::create($datos);

        return redirect()->route('tiendas.index')->with('exito', 'Tienda creada correctamente.');
    }

    public function edit(Tienda $tienda)
    {
        return view('tiendas.form', compact('tienda'));
    }

    public function update(Request $request, Tienda $tienda)
    {
        $datos = $request->validate([
            'nombre_tienda' => 'required|string|max:255|unique:tiendas,nombre_tienda,' . $tienda->id,
        ]);

        $tienda->update($datos);

        return redirect()->route('tiendas.index')->with('exito', 'Tienda actualizada correctamente.');
    }

    public function destroy(Tienda $tienda)
    {
        $tienda->delete();
        return redirect()->route('tiendas.index')->with('exito', 'Tienda eliminada correctamente.');
    }
}
