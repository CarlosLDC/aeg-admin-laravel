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
            $table->string('brand');
            $table->string('model');
            $table->unique(['brand', 'model']);
            $table->string('full_name')->virtualAs("brand || '-' || model");
            $table->string('device_type');
            $table->string('administrative_act');
            $table->date('certification_date');
            $table->decimal('price', total: 8, places: 2);
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
