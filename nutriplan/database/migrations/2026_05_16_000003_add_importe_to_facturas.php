<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        DB::statement('ALTER TABLE facturas ADD COLUMN importe DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER numero_factura');
    }
    public function down(): void {
        DB::statement('ALTER TABLE facturas DROP COLUMN importe');
    }
};
