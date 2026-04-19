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
        Schema::create('precints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_printer')->nullable()->constrained('printers');
            $table->text('serial');
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('fecha_instalacion')->nullable();
            $table->timestampTz('fecha_retiro')->nullable();
            $table->string('color');
            $table->string('estatus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precints');
    }
};
