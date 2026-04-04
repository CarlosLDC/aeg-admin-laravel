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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->restrictOnDelete();
            $table->foreignId('printer_model_id')->constrained()->restrictOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', total: 8, places: 2);
            $table->decimal('discount', total: 8, places: 2)->default(0);
            $table->foreignId('tax_id')->constrained();
            $table->decimal('tax_amount', total: 8, places: 2);
            $table->decimal('line_total', total: 8, places: 2)->storedAs('(quantity * unit_price) - discount + tax_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
