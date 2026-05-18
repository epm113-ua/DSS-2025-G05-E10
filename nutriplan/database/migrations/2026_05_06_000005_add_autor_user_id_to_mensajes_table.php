<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->foreignId('autor_user_id')->nullable()->constrained('users')->nullOnDelete()->after('conversacion_id');
        });
    }

    public function down(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->dropForeign(['autor_user_id']);
            $table->dropColumn('autor_user_id');
        });
    }
};
