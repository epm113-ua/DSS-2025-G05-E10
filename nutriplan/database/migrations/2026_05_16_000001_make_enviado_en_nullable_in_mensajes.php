<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        DB::statement('ALTER TABLE mensajes MODIFY enviado_en DATETIME NULL');
    }
    public function down(): void {
        DB::statement('ALTER TABLE mensajes MODIFY enviado_en DATETIME NOT NULL');
    }
};
