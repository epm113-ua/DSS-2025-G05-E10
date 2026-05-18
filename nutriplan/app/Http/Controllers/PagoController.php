<?php
namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    private const FORMAS = ['Tarjeta','Transferencia','Efectivo','Bizum','PayPal','Cheque'];

    public function index(Request $request)
    {
        $query = Pago::with('factura.paciente');
        if ($ids = $this->pacienteIdsVisibles()) {
            $query->whereHas('factura',fn($q)=>$q->whereIn('paciente_id',$ids));
        }
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request){
                $q->where('nombre_titular','like',"%{$request->buscar}%")
                  ->orWhereHas('factura',fn($f)=>$f->where('numero_factura','like',"%{$request->buscar}%"));
            });
        }
        if ($request->filled('forma_pago')) $query->where('forma_pago',$request->forma_pago);
        $orden  = in_array($request->orden,['fecha_pago','nombre_titular','importe']) ? $request->orden : 'fecha_pago';
        $dir    = $request->dir === 'asc' ? 'asc' : 'desc';
        $pagos  = $query->orderBy($orden,$dir)->paginate(10)->withQueryString();
        $formas = self::FORMAS;
        return view('pagos.index', compact('pagos','orden','dir','formas'));
    }

    public function create()
    {
        $facturas = $this->nutricionistaId()
            ? Factura::whereHas('paciente',fn($q)=>$q->where('nutricionista_id',$this->nutricionistaId()))->orderBy('numero_factura')->get()
            : Factura::orderBy('numero_factura')->get();
        $formas = self::FORMAS;
        return view('pagos.form', compact('facturas','formas'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'factura_id'    =>'required|exists:facturas,id',
            'nombre_titular'=>'required|string|max:255',
            'importe'       =>'required|numeric|min:0',
            'forma_pago'    =>'required|string|max:100',
            'fecha_pago'    =>'required|date',
        ]);
        Pago::create($datos);
        // Marcar factura como pagada
        Factura::find($datos['factura_id'])->update(['pagado_en'=>$datos['fecha_pago']]);
        return redirect()->route('pagos.index')->with('exito','Pago registrado correctamente.');
    }

    public function show(Pago $pago) { return view('pagos.show', compact('pago')); }

    public function edit(Pago $pago)
    {
        $facturas = Factura::orderBy('numero_factura')->get();
        $formas   = self::FORMAS;
        return view('pagos.form', compact('pago','facturas','formas'));
    }

    public function update(Request $request, Pago $pago)
    {
        $datos = $request->validate([
            'factura_id'    =>'required|exists:facturas,id',
            'nombre_titular'=>'required|string|max:255',
            'importe'       =>'required|numeric|min:0',
            'forma_pago'    =>'required|string|max:100',
            'fecha_pago'    =>'required|date',
        ]);
        $pago->update($datos);
        return redirect()->route('pagos.index')->with('exito','Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('exito','Pago eliminado correctamente.');
    }
}
