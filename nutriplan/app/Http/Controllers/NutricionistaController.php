<?php

namespace App\Http\Controllers;

use App\Models\Nutricionista;
use App\Models\Tienda;
use Illuminate\Http\Request;

class NutricionistaController extends Controller
{
    public function index(Request $request)
    {
        $query = Nutricionista::with('tienda');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('nombre_completo', 'like', "%{$term}%")
                  ->orWhere('especialidad', 'like', "%{$term}%")
                  ->orWhere('ciudad', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'nombre_completo');
        $dir   = $request->get('dir', 'asc');
        $columnas = ['nombre_completo', 'especialidad', 'ciudad', 'valoracion_media'];
        if (!in_array($orden, $columnas)) $orden = 'nombre_completo';

        $nutricionistas = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('nutricionistas.index', compact('nutricionistas', 'orden', 'dir'));
    }

    public function create()
    {
        $tiendas = Tienda::orderBy('nombre_tienda')->get();
        return view('nutricionistas.form', compact('tiendas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'tienda_id'        => 'required|exists:tiendas,id',
            'nombre_completo'  => 'required|string|max:255',
            'especialidad'     => 'required|string|max:255',
            'ciudad'           => 'required|string|max:255',
            'valoracion_media' => 'required|numeric|min:0|max:5',
        ]);

        Nutricionista::create($datos);

        return redirect()->route('nutricionistas.index')
                         ->with('exito', 'Nutricionista creado correctamente.');
    }

    public function edit(Nutricionista $nutricionista)
    {
        $tiendas = Tienda::orderBy('nombre_tienda')->get();
        return view('nutricionistas.form', compact('nutricionista', 'tiendas'));
    }

    public function update(Request $request, Nutricionista $nutricionista)
    {
        $datos = $request->validate([
            'tienda_id'        => 'required|exists:tiendas,id',
            'nombre_completo'  => 'required|string|max:255',
            'especialidad'     => 'required|string|max:255',
            'ciudad'           => 'required|string|max:255',
            'valoracion_media' => 'required|numeric|min:0|max:5',
        ]);

        $nutricionista->update($datos);

        return redirect()->route('nutricionistas.index')
                         ->with('exito', 'Nutricionista actualizado correctamente.');
    }

    public function destroy(Nutricionista $nutricionista)
    {
        $nutricionista->delete();

        return redirect()->route('nutricionistas.index')
                         ->with('exito', 'Nutricionista eliminado correctamente.');
    }
}
