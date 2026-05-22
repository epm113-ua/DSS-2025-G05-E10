<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\{ForgotPasswordController,LoginController,RegisterController,ResetPasswordController};
use App\Http\Controllers\{CitaController,ConversacionController,DashboardController,FacturaController,HomeController,
    IngredienteController,ItemPlanController,MedicionController,MensajeController,NutricionistaController,
    OfertaIngredienteController,PacienteController,PacientePanelController,PagoController,
    PlanSemanalController,PublicoController,RecetaController,TiendaController};
use Illuminate\Support\Facades\Route;

// ── Pública ──────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return app(PublicoController::class)->inicio();
})->name('inicio');
Route::get('/sobre',     [PublicoController::class,'sobre'])->name('sobre');
Route::get('/contacto',  [PublicoController::class,'contacto'])->name('contacto');
Route::post('/contacto', [PublicoController::class,'enviarContacto'])->name('contacto.enviar');

// ── Auth ─────────────────────────────────────────────────
Route::middleware('guest')->group(function(){
    Route::get('/login',                 [LoginController::class,'showLoginForm'])->name('login');
    Route::post('/login',                [LoginController::class,'login']);
    Route::get('/register',              [RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('/register',             [RegisterController::class,'register']);
    Route::get('/password/reset',        [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email',       [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}',[ResetPasswordController::class,'showResetForm'])->name('password.reset');
    Route::post('/password/reset',       [ResetPasswordController::class,'reset'])->name('password.update');
});
Route::post('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth');
Route::get('/home',    [HomeController::class,'index'])->name('home')->middleware('auth');

// ── Panel Paciente ────────────────────────────────────────
Route::middleware(['auth','rol:paciente'])->prefix('paciente')->name('paciente.')->group(function(){
    Route::get('/mi-dia',          [PacientePanelController::class,'miDia'])->name('mi-dia');
    Route::get('/mi-plan',         [PacientePanelController::class,'miPlan'])->name('mi-plan');
    Route::get('/mi-progreso',     [PacientePanelController::class,'miProgreso'])->name('mi-progreso');
    Route::get('/mis-consultas',   [PacientePanelController::class,'misConsultas'])->name('mis-consultas');
    Route::get('/mis-facturas',    [PacientePanelController::class,'misFacturas'])->name('mis-facturas');
    Route::get('/mi-perfil',       [PacientePanelController::class,'miPerfil'])->name('mi-perfil');
    // POST para que funcione con enctype multipart/form-data
    Route::post('/mi-perfil',      [PacientePanelController::class,'actualizarPerfil'])->name('mi-perfil.update');
    Route::post('/solicitar-cita', [PacientePanelController::class,'solicitarCita'])->name('solicitar-cita');
    Route::get('/mis-mensajes',    [PacientePanelController::class,'misMensajes'])->name('mis-mensajes');
    // Ruta POST de mensajes accesible para paciente
    Route::post('/enviar-mensaje', [MensajeController::class,'store'])->name('enviar-mensaje');
});

// ── Nutricionista + Admin ─────────────────────────────────
Route::middleware(['auth','rol:nutricionista,admin'])->group(function(){
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('pacientes',           PacienteController::class);
    Route::resource('citas',               CitaController::class);
    Route::resource('recetas',             RecetaController::class);
    Route::resource('ingredientes',        IngredienteController::class);
    Route::resource('conversaciones',      ConversacionController::class);
    Route::resource('mensajes',            MensajeController::class);
    Route::resource('facturas',            FacturaController::class);
    Route::resource('pagos',               PagoController::class);
    Route::resource('nutricionistas',      NutricionistaController::class);
    Route::resource('tiendas',             TiendaController::class);
    Route::resource('oferta-ingredientes', OfertaIngredienteController::class);
    Route::resource('item-plans',          ItemPlanController::class);

    // Parámetros explícitos para evitar pluralización incorrecta en español
    Route::resource('mediciones',    MedicionController::class)
        ->parameters(['mediciones' => 'medicion']);
    Route::resource('plan-semanales',PlanSemanalController::class)
        ->parameters(['plan-semanales' => 'planSemanal']);

    // Perfil del nutricionista
    Route::get('/nutricionista/mi-perfil',   [NutricionistaController::class,'miPerfil'])->name('nutricionista.mi-perfil');
    Route::post('/nutricionista/mi-perfil',  [NutricionistaController::class,'actualizarPerfil'])->name('nutricionista.mi-perfil.update');
});

// ── Admin exclusivo ───────────────────────────────────────
Route::middleware(['auth','rol:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/',                                      [AdminController::class,'index'])->name('index');
    Route::get('/usuarios',                              [AdminController::class,'usuarios'])->name('usuarios');
    Route::get('/usuarios/crear',                        [AdminController::class,'crearUsuario'])->name('usuarios.crear');
    Route::post('/usuarios',                             [AdminController::class,'guardarUsuario'])->name('usuarios.store');
    Route::patch('/usuarios/{usuario}/toggle',           [AdminController::class,'toggleAdmin'])->name('usuarios.toggle');
    Route::delete('/usuarios/{usuario}',                 [AdminController::class,'eliminarUsuario'])->name('usuarios.eliminar');
});
