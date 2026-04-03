<?php

use App\Enums\PaymentStatus;
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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained()->restrictOnDelete();
            $table->date('purchase_date');
            $table->decimal('subtotal', total: 10, places: 2);
            $table->decimal('discount', total: 10, places: 2)->default(0);
            $table->decimal('tax', total: 10, places: 2);
            $table->decimal('total', total: 10, places: 2)->storedAs('subtotal - discount + tax');
            $table->string('payment_term');
            $table->date('due_date')->nullable();
            $table->string('payment_status')->default(PaymentStatus::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
