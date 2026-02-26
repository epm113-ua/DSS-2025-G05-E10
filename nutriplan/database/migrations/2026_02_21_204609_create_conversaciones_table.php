<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('nutricionista_id')->constrained('nutricionistas')->cascadeOnDelete();
            $table->foreignId('cita_id')->constrained('citas')->cascadeOnDelete();
            $table->string('colaboracion');
            $table->integer('porcentaje');
            $table->string('mensaje_resumen')->nullable();
            $table->dateTime('creado_en');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversaciones');
    }
};