<?php
namespace App\Http\Controllers;

use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::with(['nutricionista:id,nombre_completo','user:id,rol'])
            ->select(['id','nombre_completo','ciudad','objetivos','foto','nutricionista_id','user_id'])
            ->latest('nombre_completo');
        if ($nid = $this->nutricionistaId()) $query->where('nutricionista_id', $nid);
        if ($request->filled('buscar'))       $query->where('nombre_completo','like',"%{$request->buscar}%");
        if ($request->filled('ciudad'))       $query->where('ciudad','like',"%{$request->ciudad}%");
        if ($request->filled('nutricionista_id') && !$this->nutricionistaId())
            $query->where('nutricionista_id', $request->nutricionista_id);

        $orden = in_array($request->orden,['nombre_completo','fecha_nacimiento','ciudad']) ? $request->orden : 'nombre_completo';
        $dir   = $request->dir === 'desc' ? 'desc' : 'asc';

        $pacientes      = $query->orderBy($orden,$dir)->paginate(15)->withQueryString();
        $nutricionistas = auth()->user()->esAdmin() ? Nutricionista::select('id','nombre_completo')->orderBy('nombre_completo')->get() : collect();
        return view('pacientes.index', compact('pacientes','nutricionistas','orden','dir'));
    }

    public function create()
    {
        // Solo admin puede crear pacientes desde el CRUD
        if (auth()->user()->esNutricionista()) {
            return redirect()->route('pacientes.index')
                ->with('error','Los nutricionistas no pueden crear pacientes directamente. El paciente debe registrarse desde la web pública.');
        }
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        return view('pacientes.form', compact('nutricionistas'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->esNutricionista()) {
            return redirect()->route('pacientes.index')
                ->with('error','Acción no permitida.');
        }
        $v = $request->validate([
            'nutricionista_id' => ['required','exists:nutricionistas,id'],
            'nombre_completo'  => ['required','string','max:255'],
            'fecha_nacimiento' => ['nullable','date'],
            'ciudad'           => ['nullable','string','max:100'],
            'objetivos'        => ['nullable','string','max:500'],
            'foto'             => ['nullable','image','max:2048'],
            'email'            => ['nullable','email','unique:users,email'],
            'password'         => ['nullable','string','min:8'],
        ]);

        DB::transaction(function() use ($v,$request) {
            $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('fotos','public') : null;
            $paciente = Paciente::create([
                'nutricionista_id' => $v['nutricionista_id'],
                'nombre_completo'  => $v['nombre_completo'],
                'fecha_nacimiento' => $v['fecha_nacimiento'] ?? null,
                'ciudad'           => $v['ciudad'] ?? null,
                'objetivos'        => $v['objetivos'] ?? null,
                'foto'             => $fotoPath,
            ]);
            if (!empty($v['email']) && !empty($v['password'])) {
                $user = User::create(['name'=>$v['nombre_completo'],'email'=>$v['email'],'password'=>Hash::make($v['password']),'rol'=>'paciente']);
                $paciente->update(['user_id'=>$user->id]);
            }
        });
        return redirect()->route('pacientes.index')->with('exito','Paciente creado correctamente.');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load(['nutricionista','mediciones','citas','user']);
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        return view('pacientes.form', compact('paciente','nutricionistas'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $v = $request->validate([
            'nombre_completo'  => ['required','string','max:255'],
            'fecha_nacimiento' => ['nullable','date'],
            'ciudad'           => ['nullable','string','max:100'],
            'objetivos'        => ['nullable','string','max:500'],
            'foto'             => ['nullable','image','max:2048'],
        ]);
        // Solo admin puede cambiar la foto desde el CRUD
        if (auth()->user()->esAdmin() && $request->hasFile('foto')) {
            if ($paciente->foto) Storage::disk('public')->delete($paciente->foto);
            $v['foto'] = $request->file('foto')->store('fotos','public');
        } else {
            unset($v['foto']);
        }
        $paciente->update($v);
        return redirect()->route('pacientes.show',$paciente)->with('exito','Paciente actualizado.');
    }

    public function destroy(Paciente $paciente)
    {
        if ($paciente->foto) Storage::disk('public')->delete($paciente->foto);
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('exito','Paciente eliminado.');
    }
}
