<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nutricionistas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('especialidad');
            $table->string('ciudad');
            $table->decimal('valoracion_media', 3, 2)->default(0); // 0.00 - 9.99
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutricionistas');
    }
};