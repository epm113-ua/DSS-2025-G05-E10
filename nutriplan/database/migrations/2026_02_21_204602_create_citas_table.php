<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nutricionista_id')
                ->constrained('nutricionistas')
                ->cascadeOnDelete();

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete();

            // En el diagrama: inicio: date, fin: datetime
            // Si queréis horas en inicio, cambiad a dateTime('inicio')
            $table->dateTime('inicio');
            $table->dateTime('fin');

            $table->string('estado');
            $table->string('motivo');

            $table->timestamps();

            $table->index(['nutricionista_id', 'inicio']);
            $table->index(['paciente_id', 'inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};