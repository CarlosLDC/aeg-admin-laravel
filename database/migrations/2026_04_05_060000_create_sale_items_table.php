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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->restrictOnDelete();
            $table->foreignId('printer_id')->constrained('printers')->restrictOnDelete()->unique();
            $table->foreignId('tax_id')->constrained()->restrictOnDelete();

            // Llenados por el usuario
            $table->decimal('unit_price', total: 8, places: 2);
            $table->decimal('discount', total: 8, places: 2);
            $table->decimal('applied_tax_rate', total: 5, places: 4);

            // Calculados por la aplicación
            $table->decimal('line_total', total: 8, places: 2)->default(0);
            $table->decimal('tax_amount', total: 8, places: 2)->default(0);
            $table->decimal('grand_total', total: 8, places: 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
