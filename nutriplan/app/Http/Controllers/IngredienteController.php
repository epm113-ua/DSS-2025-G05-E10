<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use App\Models\Tienda;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingrediente::with('tienda');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $orden = $request->get('orden', 'nombre');
        $dir   = $request->get('dir', 'asc');
        if (!in_array($orden, ['nombre'])) $orden = 'nombre';

        $ingredientes = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('ingredientes.index', compact('ingredientes', 'orden', 'dir'));
    }

    public function create()
    {
        $tiendas = Tienda::orderBy('nombre_tienda')->get();
        return view('ingredientes.form', compact('tiendas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'tienda_id' => 'required|exists:tiendas,id',
            'nombre'    => 'required|string|max:255',
        ]);

        Ingrediente::create($datos);

        return redirect()->route('ingredientes.index')->with('exito', 'Ingrediente creado correctamente.');
    }

    public function edit(Ingrediente $ingrediente)
    {
        $tiendas = Tienda::orderBy('nombre_tienda')->get();
        return view('ingredientes.form', compact('ingrediente', 'tiendas'));
    }

    public function update(Request $request, Ingrediente $ingrediente)
    {
        $datos = $request->validate([
            'tienda_id' => 'required|exists:tiendas,id',
            'nombre'    => 'required|string|max:255',
        ]);

        $ingrediente->update($datos);

        return redirect()->route('ingredientes.index')->with('exito', 'Ingrediente actualizado correctamente.');
    }

    public function destroy(Ingrediente $ingrediente)
    {
        $ingrediente->delete();
        return redirect()->route('ingredientes.index')->with('exito', 'Ingrediente eliminado correctamente.');
    }
}
