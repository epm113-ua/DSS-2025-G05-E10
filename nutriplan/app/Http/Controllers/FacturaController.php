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
        if ($ids = $this->pacienteIdsVisibles()) $query->whereIn('paciente_id',$ids);
        if ($request->filled('buscar'))       $query->where('numero_factura','like',"%{$request->buscar}%");
        if ($request->filled('paciente_id'))  $query->where('paciente_id',$request->paciente_id);
        if ($request->filled('estado')) {
            if ($request->estado === 'pagada')   $query->whereNotNull('pagado_en');
            if ($request->estado === 'pendiente') $query->whereNull('pagado_en');
        }
        $orden    = in_array($request->orden,['numero_factura','importe','pagado_en']) ? $request->orden : 'numero_factura';
        $dir      = $request->dir === 'desc' ? 'desc' : 'asc';
        $facturas = $query->orderBy($orden,$dir)->paginate(10)->withQueryString();
        $pacientes= $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('facturas.index', compact('facturas','orden','dir','pacientes'));
    }

    public function create()
    {
        $pacientes = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('facturas.form', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'paciente_id'    =>'required|exists:pacientes,id',
            'numero_factura' =>'nullable|string|max:50|unique:facturas,numero_factura',
            'importe'        =>'required|numeric|min:0',
            'pagado_en'      =>'nullable|date',
        ]);
        if (empty($datos['numero_factura'])) {
            $datos['numero_factura'] = 'F-'.date('Ymd').'-'.str_pad(Factura::count()+1,4,'0',STR_PAD_LEFT);
        }
        Factura::create($datos);
        return redirect()->route('facturas.index')->with('exito','Factura creada correctamente.');
    }

    public function show(Factura $factura) { return view('facturas.show', compact('factura')); }

    public function edit(Factura $factura)
    {
        $pacientes = $this->nutricionistaId()
            ? Paciente::where('nutricionista_id',$this->nutricionistaId())->orderBy('nombre_completo')->get()
            : Paciente::orderBy('nombre_completo')->get();
        return view('facturas.form', compact('factura','pacientes'));
    }

    public function update(Request $request, Factura $factura)
    {
        $datos = $request->validate([
            'paciente_id'    =>'required|exists:pacientes,id',
            'numero_factura' =>'required|string|max:50|unique:facturas,numero_factura,'.$factura->id,
            'importe'        =>'required|numeric|min:0',
            'pagado_en'      =>'nullable|date',
        ]);
        $factura->update($datos);
        return redirect()->route('facturas.index')->with('exito','Factura actualizada correctamente.');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('exito','Factura eliminada correctamente.');
    }
}
