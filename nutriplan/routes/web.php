<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return redirect()->route('nutricionistas.index');
});

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
