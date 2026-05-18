<?php
namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Factura;
use App\Models\Ingrediente;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\Receta;
use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $resumen = [
            'nutricionistas'     => Nutricionista::count(),
            'pacientes'          => Paciente::count(),
            'usuarios'           => User::count(),
            'citas_pendientes'   => Cita::where('estado','pendiente')->count(),
            'citas_completadas'  => Cita::where('estado','completada')->count(),
            'recetas'            => Receta::count(),
            'tiendas'            => Tienda::count(),
            'ingredientes'       => Ingrediente::count(),
            'facturas_pendientes'=> Factura::whereNull('pagado_en')->count(),
            'facturas_pagadas'   => Factura::whereNotNull('pagado_en')->count(),
            'pagos'              => Pago::count(),
        ];
        return view('admin.index', compact('resumen'));
    }

    public function usuarios(Request $request)
    {
        $query = User::with(['paciente','nutricionista'])->latest();
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request){
                $q->where('name','like',"%{$request->buscar}%")
                  ->orWhere('email','like',"%{$request->buscar}%");
            });
        }
        if ($request->filled('rol')) $query->where('rol',$request->rol);
        $usuarios = $query->paginate(20)->withQueryString();
        return view('admin.usuarios', compact('usuarios'));
    }

    public function crearUsuario()
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        return view('admin.crear-usuario', compact('nutricionistas'));
    }

    public function guardarUsuario(Request $request)
    {
        $v = $request->validate([
            'name'             => ['required','string','max:255'],
            'email'            => ['required','email','unique:users,email'],
            'password'         => ['required','string','min:8'],
            'rol'              => ['required','in:admin,nutricionista,paciente'],
            'nutricionista_id' => ['required_if:rol,paciente','nullable','exists:nutricionistas,id'],
        ]);

        $user = User::create([
            'name'     => $v['name'],
            'email'    => $v['email'],
            'password' => Hash::make($v['password']),
            'rol'      => $v['rol'],
            'is_admin' => $v['rol'] === 'admin',
        ]);

        if ($v['rol'] === 'paciente' && !empty($v['nutricionista_id'])) {
            Paciente::create([
                'user_id'         => $user->id,
                'nutricionista_id'=> $v['nutricionista_id'],
                'nombre_completo' => $v['name'],
            ]);
        } elseif ($v['rol'] === 'nutricionista') {
            Nutricionista::create([
                'user_id'         => $user->id,
                'nombre_completo' => $v['name'],
                'especialidad'    => 'General',
                'ciudad'          => '—',
                'valoracion_media'=> 0,
            ]);
        }

        return redirect()->route('admin.usuarios')->with('exito','Usuario creado correctamente.');
    }

    public function toggleAdmin(User $usuario)
    {
        if ($usuario->id === Auth::id()) {
            return back()->with('error','No puedes modificar tu propio rol.');
        }
        $nuevoRol = $usuario->esAdmin() ? 'nutricionista' : 'admin';
        $usuario->update(['rol'=>$nuevoRol,'is_admin'=>$nuevoRol==='admin']);
        return back()->with('exito',"Rol de {$usuario->name} actualizado a {$nuevoRol}.");
    }

    public function eliminarUsuario(User $usuario)
    {
        if ($usuario->id === Auth::id()) {
            return back()->with('error','No puedes eliminarte a ti mismo.');
        }
        $usuario->delete();
        return back()->with('exito',"Usuario {$usuario->name} eliminado.");
    }
}
