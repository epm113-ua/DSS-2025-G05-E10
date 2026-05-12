<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mediciones', function (Blueprint $table) {
            if (!Schema::hasColumn('mediciones', 'imc')) {
                $table->decimal('imc', 5, 2)->nullable()->after('porcentaje_grasa');
            }
            if (!Schema::hasColumn('mediciones', 'notas')) {
                $table->text('notas')->nullable()->after('imc');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mediciones', function (Blueprint $table) {
            if (Schema::hasColumn('mediciones', 'notas')) {
                $table->dropColumn('notas');
            }
            if (Schema::hasColumn('mediciones', 'imc')) {
                $table->dropColumn('imc');
            }
        });
    }
};
