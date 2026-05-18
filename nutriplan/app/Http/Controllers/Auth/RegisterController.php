<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Nutricionista;
use App\Services\RegistroUsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(private RegistroUsuarioService $registro) {}

    public function showRegistrationForm()
    {
        $nutricionistas = Nutricionista::orderBy('nombre_completo')->get();
        return view('auth.register', compact('nutricionistas'));
    }

    public function register(Request $request)
    {
        $rol = $request->input('rol', 'paciente');

        if ($rol === 'nutricionista') {
            $request->validate([
                'name'        => ['required', 'string', 'max:255'],
                'email'       => ['required', 'email', 'unique:users'],
                'password'    => ['required', 'string', 'min:8', 'confirmed'],
                'especialidad'=> ['required', 'string', 'max:100'],
                'ciudad'      => ['required', 'string', 'max:100'],
            ]);
            $user = $this->registro->registrarNutricionista($request->only(
                'name', 'email', 'password', 'especialidad', 'ciudad'
            ));
        } else {
            $request->validate([
                'name'             => ['required', 'string', 'max:255'],
                'email'            => ['required', 'email', 'unique:users'],
                'password'         => ['required', 'string', 'min:8', 'confirmed'],
                'nutricionista_id' => ['required', 'exists:nutricionistas,id'],
            ]);
            $user = $this->registro->registrarPaciente($request->only(
                'name', 'email', 'password', 'nutricionista_id'
            ));
        }

        Auth::login($user);
        return redirect($user->rutaInicio())->with('exito', '¡Bienvenido/a a NutriPlan!');
    }
}
