<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutricionista_id')->constrained('nutricionistas')->cascadeOnDelete();
            $table->string('nombre');
            $table->text('preparacion');
            $table->integer('calorias_kcal');
            $table->decimal('carbohidratos_g', 6, 2);
            $table->decimal('grasas_g', 6, 2);
            $table->string('ruta_foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};