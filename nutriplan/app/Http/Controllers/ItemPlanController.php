<?php

namespace App\Http\Controllers;

use App\Models\ItemPlan;
use App\Models\PlanSemanal;
use App\Models\Receta;
use Illuminate\Http\Request;

class ItemPlanController extends Controller
{
    private array $diasSemana = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
        4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo',
    ];

    private array $tiposComida = ['Desayuno', 'Almuerzo', 'Cena', 'Merienda'];

    public function index(Request $request)
    {
        $query = ItemPlan::with(['planSemanal', 'receta']);

        if ($request->filled('buscar')) {
            $term = $request->buscar;
            $query->where(function ($q) use ($term) {
                $q->where('tipo_comida', 'like', "%{$term}%")
                  ->orWhere('notas', 'like', "%{$term}%");
            });
        }

        $orden = $request->get('orden', 'dia_semana');
        $dir   = $request->get('dir', 'asc');
        if (!in_array($orden, ['dia_semana', 'tipo_comida'])) $orden = 'dia_semana';

        $items = $query->orderBy($orden, $dir)->paginate(10)->withQueryString();

        return view('item-plans.index', compact('items', 'orden', 'dir'));
    }

    public function create()
    {
        $planes        = PlanSemanal::with('cita.paciente')->get();
        $recetas       = Receta::orderBy('nombre')->get();
        $diasSemana    = $this->diasSemana;
        $tiposComida   = $this->tiposComida;
        return view('item-plans.form', compact('planes', 'recetas', 'diasSemana', 'tiposComida'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'plan_semanal_id' => 'required|exists:plan_semanales,id',
            'receta_id'       => 'required|exists:recetas,id',
            'dia_semana'      => 'required|integer|min:1|max:7',
            'tipo_comida'     => 'required|string|max:50',
            'notas'           => 'nullable|string|max:500',
        ]);

        ItemPlan::create($datos);

        return redirect()->route('item-plans.index')->with('exito', 'Ítem de plan creado correctamente.');
    }

    public function edit(ItemPlan $itemPlan)
    {
        $planes      = PlanSemanal::with('cita.paciente')->get();
        $recetas     = Receta::orderBy('nombre')->get();
        $diasSemana  = $this->diasSemana;
        $tiposComida = $this->tiposComida;
        return view('item-plans.form', compact('itemPlan', 'planes', 'recetas', 'diasSemana', 'tiposComida'));
    }

    public function update(Request $request, ItemPlan $itemPlan)
    {
        $datos = $request->validate([
            'plan_semanal_id' => 'required|exists:plan_semanales,id',
            'receta_id'       => 'required|exists:recetas,id',
            'dia_semana'      => 'required|integer|min:1|max:7',
            'tipo_comida'     => 'required|string|max:50',
            'notas'           => 'nullable|string|max:500',
        ]);

        $itemPlan->update($datos);

        return redirect()->route('item-plans.index')->with('exito', 'Ítem de plan actualizado correctamente.');
    }

    public function destroy(ItemPlan $itemPlan)
    {
        $itemPlan->delete();
        return redirect()->route('item-plans.index')->with('exito', 'Ítem de plan eliminado correctamente.');
    }
}
