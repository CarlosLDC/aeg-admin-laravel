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
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('printer_model_id')->constrained()->restrictOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', total: 8, places: 2);
            $table->decimal('discount', total: 8, places: 2)->default(0);
            $table->decimal('line_total', total: 8, places: 2)->storedAs('(quantity * unit_price) - discount');
            $table->foreignId('tax_id')->constrained()->restrictOnDelete();
            $table->decimal('applied_tax_rate', total: 5, places: 4);
            $table->decimal('tax_amount', total: 8, places: 2)->storedAs('((quantity * unit_price) - discount) * applied_tax_rate');
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
