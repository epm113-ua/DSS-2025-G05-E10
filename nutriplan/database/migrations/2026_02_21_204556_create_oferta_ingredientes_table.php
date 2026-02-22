<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oferta_ingredientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tienda_id')
                ->constrained('tiendas')
                ->cascadeOnDelete();

            $table->foreignId('ingrediente_id')
                ->constrained('ingredientes')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('descripcion_oferta');

            $table->timestamps();

            $table->index(['tienda_id', 'ingrediente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oferta_ingredientes');
    }
};