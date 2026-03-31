<?php

namespace App\Http\Controllers;

use App\Models\OfertaIngrediente;
use App\Models\Ingrediente;
use App\Models\Tienda;
use Illuminate\Http\Request;

class OfertaIngredienteController extends Controller
{
    public function index(Request $request)
    {
        $query = OfertaIngrediente::with(['ingrediente', 'tienda']);

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('descripcion_oferta', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'nombre');
        $dir   = $request->get('dir', 'asc');
        if (!in_array($orden, ['nombre', 'descripcion_oferta'])) $orden = 'nombre';

        $ofertas = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('oferta-ingredientes.index', compact('ofertas', 'orden', 'dir'));
    }

    public function create()
    {
        $ingredientes = Ingrediente::orderBy('nombre')->get();
        $tiendas      = Tienda::orderBy('nombre_tienda')->get();
        return view('oferta-ingredientes.form', compact('ingredientes', 'tiendas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'ingrediente_id'    => 'required|exists:ingredientes,id',
            'tienda_id'         => 'required|exists:tiendas,id',
            'nombre'            => 'required|string|max:255',
            'descripcion_oferta'=> 'required|string|max:500',
        ]);

        OfertaIngrediente::create($datos);

        return redirect()->route('oferta-ingredientes.index')->with('exito', 'Oferta creada correctamente.');
    }

    public function edit(OfertaIngrediente $ofertaIngrediente)
    {
        $ingredientes = Ingrediente::orderBy('nombre')->get();
        $tiendas      = Tienda::orderBy('nombre_tienda')->get();
        return view('oferta-ingredientes.form', compact('ofertaIngrediente', 'ingredientes', 'tiendas'));
    }

    public function update(Request $request, OfertaIngrediente $ofertaIngrediente)
    {
        $datos = $request->validate([
            'ingrediente_id'    => 'required|exists:ingredientes,id',
            'tienda_id'         => 'required|exists:tiendas,id',
            'nombre'            => 'required|string|max:255',
            'descripcion_oferta'=> 'required|string|max:500',
        ]);

        $ofertaIngrediente->update($datos);

        return redirect()->route('oferta-ingredientes.index')->with('exito', 'Oferta actualizada correctamente.');
    }

    public function destroy(OfertaIngrediente $ofertaIngrediente)
    {
        $ofertaIngrediente->delete();
        return redirect()->route('oferta-ingredientes.index')->with('exito', 'Oferta eliminada correctamente.');
    }
}
