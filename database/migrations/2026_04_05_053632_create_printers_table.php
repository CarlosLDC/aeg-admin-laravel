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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();

            // Identificación
            $table->string('fiscal_serial_number')->unique();
            $table->foreignId('printer_model_id')->constrained('printer_models')->restrictOnDelete();
            $table->string('mac_address')->nullable();

            // Especificaciones Técnicas
            $table->foreignId('firmware_id')->nullable()->constrained('firmware')->restrictOnDelete();
            $table->foreignId('software_id')->nullable()->constrained('software')->restrictOnDelete();

            // Estado y Asignación
            $table->string('status');
            $table->foreignId('client_id')->nullable()->constrained('clients')->restrictOnDelete();
            $table->date('installation_date')->nullable();

            // Información de Venta
            $table->foreignId('sale_id')->nullable()->constrained('sales')->restrictOnDelete();
            $table->decimal('final_sale_price', total: 8, places: 2)->nullable();
            $table->foreignId('tax_id')->nullable()->constrained('taxes')->restrictOnDelete();
            $table->boolean('is_paid');

            // Encabezados
            $table->json('headers')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
