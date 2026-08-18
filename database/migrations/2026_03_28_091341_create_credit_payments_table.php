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
        Schema::create('credit_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_sale_id')
                ->constrained('credit_sales')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('payment_date');
            $table->decimal('amount_paid', 8, 2);
            $table->decimal('change_given', 8, 2);
            $table->decimal('amount_received', 8, 2);
            $table->string('payment_method');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_payments');
    }
};
