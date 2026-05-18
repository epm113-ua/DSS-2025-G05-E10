<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE pacientes MODIFY fecha_nacimiento DATE NULL');
        DB::statement('ALTER TABLE pacientes MODIFY ciudad VARCHAR(255) NULL');
        DB::statement('ALTER TABLE pacientes MODIFY objetivos TEXT NULL');
    }

    public function down(): void
    {
        // Reversing nullability is risky with existing data; left intentionally empty
    }
};
