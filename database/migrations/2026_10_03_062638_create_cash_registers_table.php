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
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            // Variables mapeadas directamente desde tu Livewire
            $table->date('date');
            $table->decimal('opening_amount', 10, 2);
            $table->decimal('last_closing_amount', 10, 2);
            $table->decimal('closing_amount', 10, 2);
            
            // Relación con el usuario que realiza el arqueo
            $table->foreignId('user_id')->constrained('users'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
