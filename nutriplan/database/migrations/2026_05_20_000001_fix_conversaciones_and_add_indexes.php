<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hacer cita_id nullable (antes era NOT NULL, bloqueaba crear conversaciones sin cita)
        Schema::table('conversaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('cita_id')->nullable()->change();
        });

        // Hacer porcentaje nullable con default 0
        DB::statement('ALTER TABLE conversaciones MODIFY porcentaje INT DEFAULT 0');

        // Índices de rendimiento en mensajes
        Schema::table('mensajes', function (Blueprint $table) {
            if (!Schema::hasIndex('mensajes', 'mensajes_conversacion_enviado_idx')) {
                $table->index(['conversacion_id', 'enviado_en'], 'mensajes_conversacion_enviado_idx');
            }
        });

        // Índices en conversaciones
        Schema::table('conversaciones', function (Blueprint $table) {
            if (!Schema::hasIndex('conversaciones', 'conversaciones_nutricionista_updated_idx')) {
                $table->index(['nutricionista_id', 'updated_at'], 'conversaciones_nutricionista_updated_idx');
            }
            if (!Schema::hasIndex('conversaciones', 'conversaciones_paciente_idx')) {
                $table->index('paciente_id', 'conversaciones_paciente_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->dropIndex('mensajes_conversacion_enviado_idx');
        });
        Schema::table('conversaciones', function (Blueprint $table) {
            $table->dropIndex('conversaciones_nutricionista_updated_idx');
            $table->dropIndex('conversaciones_paciente_idx');
        });
    }
};
