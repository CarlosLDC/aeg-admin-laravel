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
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->foreignId('software_provider_id')->constrained()->restrictOnDelete();

            // Nombre y versión
            $table->string('name');
            $table->string('version');

            // Restricciones de nombre y versión
            $table->unique(['name', 'version']);
            $table->string('full_name')->virtualAs("name || ' ' || 'v' || version");

            // Fecha de integración
            $table->date('integration_date')->nullable();

            // Información técnica
            $table->json('operating_systems')->nullable();
            $table->json('programming_languages')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
