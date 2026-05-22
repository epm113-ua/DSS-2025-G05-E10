<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Permitir conversaciones sin cita asociada (chat directo nutricionista ↔ paciente)
        // Eliminamos primero la FK para poder modificar la columna en MySQL
        Schema::table('conversaciones', function (Blueprint $table) {
            $table->dropForeign(['cita_id']);
        });
        DB::statement('ALTER TABLE conversaciones MODIFY cita_id BIGINT UNSIGNED NULL');
        Schema::table('conversaciones', function (Blueprint $table) {
            $table->foreign('cita_id')->references('id')->on('citas')->nullOnDelete();
        });

        // El contenido de los mensajes debe permitir textos largos (hasta 2000 chars)
        DB::statement('ALTER TABLE mensajes MODIFY contenido TEXT NOT NULL');
    }

    public function down(): void
    {
        Schema::table('conversaciones', function (Blueprint $table) {
            $table->dropForeign(['cita_id']);
        });
        DB::statement('ALTER TABLE conversaciones MODIFY cita_id BIGINT UNSIGNED NOT NULL');
        Schema::table('conversaciones', function (Blueprint $table) {
            $table->foreign('cita_id')->references('id')->on('citas')->cascadeOnDelete();
        });

        DB::statement('ALTER TABLE mensajes MODIFY contenido VARCHAR(255) NOT NULL');
    }
};
