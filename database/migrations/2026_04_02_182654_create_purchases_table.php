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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained()->restrictOnDelete();
            $table->string('invoice_number')->unique(); // Número de factura
            $table->date('purchase_date');
            $table->decimal('subtotal', total: 8, places: 2)->default(0);
            $table->decimal('global_discount', total: 8, places: 2)->default(0);
            $table->decimal('total_tax', total: 8, places: 2)->default(0);
            $table->decimal('total', total: 8, places: 2)->storedAs('subtotal - global_discount + total_tax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
