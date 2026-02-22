<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_semanal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cita_id')
                ->constrained('citas')
                ->cascadeOnDelete();

            $table->date('semanal_inicio');
            $table->string('notas')->nullable();

            $table->timestamps();

            $table->index(['cita_id', 'semanal_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_semanal');
    }
};