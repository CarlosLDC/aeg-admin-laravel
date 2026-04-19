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

            $table->foreignId('id_modelo_printer')->constrained('printer_models');
            $table->foreignId('id_software')->nullable()->constrained('software');
            $table->foreignId('id_venta')->nullable()->constrained('sales');
            $table->foreignId('id_sucursal')->nullable()->constrained('branches');

            $table->text('serial_fiscal')->unique();
            $table->decimal('precio_venta_final', total: 8, places: 2)->nullable();
            $table->string('estatus')->default('laboratorio');
            $table->foreignId('id_firmware')->nullable()->constrained('firmware');
            $table->foreignId('id_distribuidora')->nullable()->constrained('distributors');
            $table->boolean('se_pago')->default(false);
            $table->timestampTz('fecha_instalacion')->nullable();
            $table->text('version_firmware')->nullable();
            $table->text('direccion_mac')->nullable();
            $table->string('tipo_dispositivo')->default('interno');
            $table->timestampTz('created_at')->useCurrent();
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
