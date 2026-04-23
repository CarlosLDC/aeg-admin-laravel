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
            $table->string('name');
            $table->string('version');
            $table->date('integration_date');
            $table->json('operating_systems');
            $table->json('programming_languages');
            $table->string('full_name')->virtualAs("name || ' ' || 'v' || version");
            $table->timestamps();
            $table->unique(['name', 'version']);
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
