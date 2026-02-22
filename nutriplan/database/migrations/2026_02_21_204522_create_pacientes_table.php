<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nutricionista_id')
                ->constrained('nutricionistas')
                ->cascadeOnDelete();

            $table->string('nombre_completo');
            $table->date('fecha_nacimiento');
            $table->string('ciudad');
            $table->text('objetivos');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};