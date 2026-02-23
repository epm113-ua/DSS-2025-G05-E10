<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ingrediente_receta', function (Blueprint $table) {
            $table->foreignId('receta_id')->constrained('recetas')->cascadeOnDelete();
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->cascadeOnDelete();
            $table->primary(['receta_id', 'ingrediente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingrediente_receta');
    }
};