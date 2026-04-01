<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NutricionistaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\MedicionController;
use App\Http\Controllers\PlanSemanalController;
use App\Http\Controllers\ItemPlanController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\OfertaIngredienteController;
use App\Http\Controllers\ConversacionController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\PagoController;

// Dashboard principal
Route::get('/',              [DashboardController::class, 'index'])      ->name('dashboard');
Route::post('/cambiar-modo', [DashboardController::class, 'cambiarModo'])->name('cambiar-modo');

// Panel de administración
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/',         [AdminController::class, 'index'])    ->name('index');
    Route::get('/usuarios', [AdminController::class, 'usuarios']) ->name('usuarios');
    Route::post('/usuarios/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('toggle-admin');
});

// Recursos del modelo de dominio
Route::resource('nutricionistas',       NutricionistaController::class);
Route::resource('pacientes',            PacienteController::class);
Route::resource('citas',                CitaController::class);
Route::resource('recetas',              RecetaController::class);
Route::resource('ingredientes',         IngredienteController::class);
Route::resource('mediciones',           MedicionController::class);
Route::resource('plan-semanales',       PlanSemanalController::class);
Route::resource('item-plans',           ItemPlanController::class);
Route::resource('tiendas',              TiendaController::class);
Route::resource('oferta-ingredientes',  OfertaIngredienteController::class);
Route::resource('conversaciones',       ConversacionController::class);
Route::resource('facturas',             FacturaController::class);
Route::resource('mensajes',             MensajeController::class);
Route::resource('pagos',                PagoController::class);
