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
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('mixed_cash_amount', 10, 2)->nullable()->after('metodoPago');
            $table->decimal('mixed_transfer_amount', 10, 2)->nullable()->after('mixed_cash_amount');
            $table->decimal('mixed_tarjeta_amount', 10, 2)->nullable()->after('mixed_transfer_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['mixed_cash_amount', 'mixed_transfer_amount', 'mixed_tarjeta_amount']);
        });
    }
};
