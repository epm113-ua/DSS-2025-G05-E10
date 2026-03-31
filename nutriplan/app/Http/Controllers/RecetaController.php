<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Nutricionista;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    public function index(Request $request)
    {
        $query = Receta::with('nutricionista');

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('nombre', 'like', "%{$term}%")
                  ->orWhere('preparacion', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'nombre');
        $dir   = $request->get('dir', 'asc');
        $columnas = ['nombre', 'calorias_kcal', 'carbohidratos_g', 'grasas_g'];
        if (!in_array($orden, $columnas)) $orden = 'nombre';

        $recetas = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('recetas.index', compact('recetas', 'orden', 'dir'));
    }

    public function create()
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        $ingredientes   = Ingrediente::orderBy('nombre')->get();
        return view('recetas.form', compact('nutricionistas', 'ingredientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nutricionista_id'  => 'required|exists:nutricionistas,id',
            'nombre'            => 'required|string|max:255',
            'preparacion'       => 'required|string',
            'calorias_kcal'     => 'required|integer|min:0',
            'carbohidratos_g'   => 'required|numeric|min:0',
            'grasas_g'          => 'required|numeric|min:0',
            'ruta_foto'         => 'nullable|string|max:500',
            'ingredientes'      => 'nullable|array',
            'ingredientes.*'    => 'exists:ingredientes,id',
        ]);

        $receta = Receta::create($datos);

        if ($request->filled('ingredientes')) {
            $receta->ingredientes()->sync($request->ingredientes);
        }

        return redirect()->route('recetas.index')->with('exito', 'Receta creada correctamente.');
    }

    public function edit(Receta $receta)
    {
        $nutricionistas      = Nutricionista::orderBy('nombre_completo')->get();
        $ingredientes        = Ingrediente::orderBy('nombre')->get();
        $ingredientesActivos = $receta->ingredientes->pluck('id')->toArray();
        return view('recetas.form', compact('receta', 'nutricionistas', 'ingredientes', 'ingredientesActivos'));
    }

    public function update(Request $request, Receta $receta)
    {
        $datos = $request->validate([
            'nutricionista_id'  => 'required|exists:nutricionistas,id',
            'nombre'            => 'required|string|max:255',
            'preparacion'       => 'required|string',
            'calorias_kcal'     => 'required|integer|min:0',
            'carbohidratos_g'   => 'required|numeric|min:0',
            'grasas_g'          => 'required|numeric|min:0',
            'ruta_foto'         => 'nullable|string|max:500',
            'ingredientes'      => 'nullable|array',
            'ingredientes.*'    => 'exists:ingredientes,id',
        ]);

        $receta->update($datos);
        $receta->ingredientes()->sync($request->ingredientes ?? []);

        return redirect()->route('recetas.index')->with('exito', 'Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        $receta->delete();
        return redirect()->route('recetas.index')->with('exito', 'Receta eliminada correctamente.');
    }
}
