<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('item_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_semanal_id')->constrained('plan_semanales')->cascadeOnDelete();
            $table->foreignId('receta_id')->constrained('recetas')->cascadeOnDelete();
            $table->tinyInteger('dia_semana'); //1=Lunes ... 7=Domingo
            $table->string('tipo_comida');     //Desayuno, almuerzo, cena...
            $table->string('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_plans');
    }
};