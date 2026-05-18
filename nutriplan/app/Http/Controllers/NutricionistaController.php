<?php
namespace App\Http\Controllers;

use App\Models\Nutricionista;
use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class NutricionistaController extends Controller
{
    public function index(Request $request)
    {
        $query = Nutricionista::with(['tienda','user']);
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request){
                $q->where('nombre_completo','like',"%{$request->buscar}%")
                  ->orWhere('especialidad','like',"%{$request->buscar}%")
                  ->orWhere('ciudad','like',"%{$request->buscar}%");
            });
        }
        $orden = in_array($request->orden,['nombre_completo','especialidad','ciudad','valoracion_media'])
            ? $request->orden : 'nombre_completo';
        $dir   = $request->dir === 'desc' ? 'desc' : 'asc';
        $nutricionistas = $query->orderBy($orden,$dir)->paginate(15)->withQueryString();
        return view('nutricionistas.index', compact('nutricionistas','orden','dir'));
    }

    public function create()
    {
        $tiendas = Tienda::orderBy('nombre_tienda')->get();
        return view('nutricionistas.form', compact('tiendas'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'tienda_id'        => ['nullable','exists:tiendas,id'],
            'nombre_completo'  => ['required','string','max:255'],
            'especialidad'     => ['required','string','max:255'],
            'ciudad'           => ['required','string','max:255'],
            'valoracion_media' => ['required','numeric','min:0','max:5'],
            'foto'             => ['nullable','image','max:2048'],
            'email'            => ['nullable','email','unique:users,email'],
            'password'         => ['nullable','string','min:8'],
        ]);
        DB::transaction(function() use ($v,$request){
            $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('fotos','public') : null;
            $n = Nutricionista::create([
                'tienda_id'       => $v['tienda_id'] ?? null,
                'nombre_completo' => $v['nombre_completo'],
                'especialidad'    => $v['especialidad'],
                'ciudad'          => $v['ciudad'],
                'valoracion_media'=> $v['valoracion_media'],
                'foto'            => $fotoPath,
            ]);
            if (!empty($v['email']) && !empty($v['password'])) {
                $user = User::create(['name'=>$v['nombre_completo'],'email'=>$v['email'],'password'=>Hash::make($v['password']),'rol'=>'nutricionista']);
                $n->update(['user_id'=>$user->id]);
            }
        });
        return redirect()->route('nutricionistas.index')->with('exito','Nutricionista creado correctamente.');
    }

    public function show(Nutricionista $nutricionista)
    {
        $nutricionista->load(['tienda','pacientes','citas','user']);
        return view('nutricionistas.show', compact('nutricionista'));
    }

    public function edit(Nutricionista $nutricionista)
    {
        $tiendas = Tienda::orderBy('nombre_tienda')->get();
        return view('nutricionistas.form', compact('nutricionista','tiendas'));
    }

    public function update(Request $request, Nutricionista $nutricionista)
    {
        $v = $request->validate([
            'tienda_id'        => ['nullable','exists:tiendas,id'],
            'nombre_completo'  => ['required','string','max:255'],
            'especialidad'     => ['required','string','max:255'],
            'ciudad'           => ['required','string','max:255'],
            'valoracion_media' => ['required','numeric','min:0','max:5'],
            'foto'             => ['nullable','image','max:2048'],
        ]);
        if ($request->hasFile('foto')) {
            if ($nutricionista->foto) Storage::disk('public')->delete($nutricionista->foto);
            $v['foto'] = $request->file('foto')->store('fotos','public');
        } else {
            unset($v['foto']);
        }
        $nutricionista->update($v);
        return redirect()->route('nutricionistas.show',$nutricionista)->with('exito','Actualizado correctamente.');
    }

    public function destroy(Nutricionista $nutricionista)
    {
        if ($nutricionista->foto) Storage::disk('public')->delete($nutricionista->foto);
        $nutricionista->delete();
        return redirect()->route('nutricionistas.index')->with('exito','Nutricionista eliminado.');
    }

    /** Panel Mi Perfil para el nutricionista logueado */
    public function miPerfil()
    {
        $nutricionista = Auth::user()->nutricionista;
        if (!$nutricionista) abort(404);
        return view('nutricionistas.mi-perfil', compact('nutricionista'));
    }

    public function actualizarPerfil(Request $request)
    {
        $nutricionista = Auth::user()->nutricionista;
        if (!$nutricionista) abort(404);

        $v = $request->validate([
            'nombre_completo'  => ['required','string','max:255'],
            'especialidad'     => ['required','string','max:255'],
            'ciudad'           => ['required','string','max:255'],
            'foto'             => ['nullable','image','max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($nutricionista->foto) Storage::disk('public')->delete($nutricionista->foto);
            $v['foto'] = $request->file('foto')->store('fotos','public');
        } else {
            unset($v['foto']);
        }

        $nutricionista->update($v);
        Auth::user()->update(['name' => $v['nombre_completo']]);

        return back()->with('exito','Perfil actualizado correctamente.');
    }
}
