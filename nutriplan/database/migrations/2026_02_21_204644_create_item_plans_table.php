<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plan_semanal_id')
                ->constrained('plan_semanal')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('dia_semana')->comment('1..7');
            $table->string('tipo_comida');
            $table->string('notas')->nullable();

            $table->timestamps();

            // Evita duplicados del tipo: mismo plan, mismo día, misma comida
            $table->unique(['plan_semanal_id', 'dia_semana', 'tipo_comida']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_plans');
    }
};