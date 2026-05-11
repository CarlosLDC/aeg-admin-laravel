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
        Schema::create('printer_models', function (Blueprint $table) {
            $table->id();

            // Marca y modelo
            $table->string('brand');
            $table->string('model');

            // Restricciones de marca y modelo
            $table->unique(['brand', 'model']);
            $table->string('full_name')->virtualAs("brand || '-' || model");

            // Tipo de dispositivo y precio
            $table->string('device_type');
            $table->decimal('price', total: 8, places: 2);

            // Información fiscal
            $table->string('administrative_act')->nullable();
            $table->date('certification_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_models');
    }
};
