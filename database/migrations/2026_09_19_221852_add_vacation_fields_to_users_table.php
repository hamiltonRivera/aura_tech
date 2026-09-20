<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
            // Fecha de contratación (nullable por si hay usuarios antiguos sin fecha registrada aún)
            $table->date('hire_date')->nullable()->after('salary'); 
            
            // Campos para el control de vacaciones (5 dígitos en total, 2 decimales para soportar ej: 12.50)
            $table->decimal('total_days_off', 5, 2)->nullable();
            $table->decimal('days_off_taken', 5, 2)->nullable();
            $table->decimal('available_days_off', 5, 2)->nullable();
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'hire_date',
                'total_days_off',
                'days_off_taken',
                'available_days_off'
            ]);
        });
        });
    }
};
