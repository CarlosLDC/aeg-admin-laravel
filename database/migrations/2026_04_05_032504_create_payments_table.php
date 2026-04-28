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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->restrictOnDelete();

            // Base imponible del pago antes de IGTF.
            $table->decimal('amount', total: 8, places: 2);

            // Moneda usada en el pago: VES o USD.
            $table->string('currency', 3)->default('VES');

            // Tasa BCV aplicada si el pago se registró en divisas.
            $table->decimal('exchange_rate', total: 10, places: 4)->default(1);

            // Alícuota de IGTF (por ejemplo, 0.03 para 3%).
            $table->decimal('igtf_rate', total: 5, places: 4)->default(0);
            $table->decimal('igtf_amount', total: 8, places: 2)->default(0);
            $table->decimal('total_amount', total: 8, places: 2);

            $table->string('payment_method');
            $table->string('reference_number')->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['sale_id', 'payment_method']);
            $table->index('currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
