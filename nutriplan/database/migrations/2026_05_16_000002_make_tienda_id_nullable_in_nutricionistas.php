<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        DB::statement('ALTER TABLE nutricionistas MODIFY tienda_id BIGINT UNSIGNED NULL');
    }
    public function down(): void {}
};
