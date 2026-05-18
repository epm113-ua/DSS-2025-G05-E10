<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        DB::statement('ALTER TABLE pacientes ADD COLUMN foto VARCHAR(255) NULL AFTER objetivos');
        DB::statement('ALTER TABLE nutricionistas ADD COLUMN foto VARCHAR(255) NULL AFTER valoracion_media');
    }
    public function down(): void {
        DB::statement('ALTER TABLE pacientes DROP COLUMN foto');
        DB::statement('ALTER TABLE nutricionistas DROP COLUMN foto');
    }
};
