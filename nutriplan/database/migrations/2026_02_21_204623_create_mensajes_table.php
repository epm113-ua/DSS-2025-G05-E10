<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('conversacion_id')
                ->constrained('conversaciones')
                ->cascadeOnDelete();

            // En el diagrama aparece "tinyint" pero para mensajes reales debe ser texto
            $table->text('contenido');

            $table->foreignId('factura_id')
                ->nullable()
                ->constrained('facturas')
                ->nullOnDelete();

            $table->dateTime('enviado_en');

            $table->timestamps();

            $table->index(['conversacion_id', 'enviado_en']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};