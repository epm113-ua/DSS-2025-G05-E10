<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        DB::statement('ALTER TABLE pagos ADD COLUMN importe DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER nombre_titular');
        DB::statement("ALTER TABLE pagos ADD COLUMN forma_pago VARCHAR(100) NOT NULL DEFAULT 'Transferencia' AFTER importe");
    }
    public function down(): void {
        DB::statement('ALTER TABLE pagos DROP COLUMN importe');
        DB::statement('ALTER TABLE pagos DROP COLUMN forma_pago');
    }
};
