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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            // Relación con el empleado
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Fechas del período
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Bases Salariales
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->decimal('quarter_salary', 10, 2)->nullable();
            $table->decimal('daily_salary', 10, 2)->nullable();
            
            // Días Feriados
            $table->integer('holly_days')->default(0);
            $table->decimal('total_payment_holly_days', 10, 2)->default(0);
            
            // Totales Brutos
            $table->decimal('total_payment_monthly', 10, 2)->nullable();
            $table->decimal('total_payment_quarter', 10, 2)->nullable();
            
            // Deducciones de Ley
            $table->string('apply_deductions', 2)->default('no'); // 'si' o 'no'
            $table->decimal('inss_deduction', 10, 2)->default(0);
            $table->decimal('ir_deduction', 10, 2)->default(0);
            
            // Neto a pagar
            $table->decimal('net_payment_quarter', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
