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
        Schema::table('printers', function (Blueprint $table) {
            $table->dropColumn('version_firmware');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('printers', function (Blueprint $table) {
            $table->text('version_firmware')->nullable()->after('fecha_instalacion');
        });
    }
};
