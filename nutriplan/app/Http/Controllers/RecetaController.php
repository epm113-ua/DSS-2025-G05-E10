<?php
namespace App\Http\Controllers;

use App\Models\Nutricionista;
use App\Models\Receta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    public function index(Request $request)
    {
        $query = Receta::with('nutricionista');
        // Nutricionista solo ve sus propias recetas
        if ($nid = $this->nutricionistaId()) $query->where('nutricionista_id', $nid);

        if ($request->filled('buscar'))
            $query->where('nombre','like',"%{$request->buscar}%");
        if ($request->filled('nutricionista_id') && !$this->nutricionistaId())
            $query->where('nutricionista_id', $request->nutricionista_id);

        $orden   = in_array($request->orden,['nombre','calorias_kcal','carbohidratos_g','grasas_g']) ? $request->orden : 'nombre';
        $dir     = $request->dir === 'desc' ? 'desc' : 'asc';
        $recetas = $query->orderBy($orden,$dir)->paginate(15)->withQueryString();
        $nutricionistas = auth()->user()->esAdmin() ? Nutricionista::orderBy('nombre_completo')->get() : collect();
        return view('recetas.index', compact('recetas','orden','dir','nutricionistas'));
    }

    public function create()
    {
        $nutricionistas = auth()->user()->esAdmin()
            ? Nutricionista::orderBy('nombre_completo')->get()
            : Nutricionista::where('id',$this->nutricionistaId())->get();
        return view('recetas.form', compact('nutricionistas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nutricionista_id' => ['required','exists:nutricionistas,id'],
            'nombre'           => ['required','string','max:255'],
            'preparacion'      => ['required','string'],
            'calorias_kcal'    => ['required','integer','min:0'],
            'carbohidratos_g'  => ['required','numeric','min:0'],
            'grasas_g'         => ['required','numeric','min:0'],
        ]);
        Receta::create($datos);
        return redirect()->route('recetas.index')->with('exito','Receta creada correctamente.');
    }

    public function show(Receta $receta) { return view('recetas.show', compact('receta')); }

    public function edit(Receta $receta)
    {
        $nutricionistas = auth()->user()->esAdmin()
            ? Nutricionista::orderBy('nombre_completo')->get()
            : Nutricionista::where('id',$this->nutricionistaId())->get();
        return view('recetas.form', compact('receta','nutricionistas'));
    }

    public function update(Request $request, Receta $receta)
    {
        $datos = $request->validate([
            'nutricionista_id' => ['required','exists:nutricionistas,id'],
            'nombre'           => ['required','string','max:255'],
            'preparacion'      => ['required','string'],
            'calorias_kcal'    => ['required','integer','min:0'],
            'carbohidratos_g'  => ['required','numeric','min:0'],
            'grasas_g'         => ['required','numeric','min:0'],
        ]);
        $receta->update($datos);
        return redirect()->route('recetas.index')->with('exito','Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        $receta->delete();
        return redirect()->route('recetas.index')->with('exito','Receta eliminada correctamente.');
    }
}
