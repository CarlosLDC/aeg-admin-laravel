<?php

use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('recalculates payment totals when it is saved', function () {
    $purchase = Purchase::factory()->create();

    Payment::create([
        'purchase_id' => $purchase->id,
        'amount' => 100,
        'currency' => 'USD',
        'exchange_rate' => 40.5,
        'igtf_rate' => 0.03,
        'igtf_amount' => 0,
        'total_amount' => 0,
        'payment_method' => PaymentMethod::Zelle->value,
        'reference_number' => 'ZE-123456789012',
        'paid_at' => now(),
    ]);

    assertDatabaseHas(Payment::class, [
        'reference_number' => 'ZE-123456789012',
        'igtf_amount' => '3.00',
        'total_amount' => '103.00',
    ]);
});

it('touches the related purchases when a payment is moved to another purchase', function () {
    $firstPurchase = Purchase::factory()->create();
    $secondPurchase = Purchase::factory()->create();

    $payment = Payment::factory()->for($firstPurchase)->create();

    $firstUpdatedAt = $firstPurchase->fresh()->updated_at;
    $secondUpdatedAt = $secondPurchase->fresh()->updated_at;

    Carbon::setTestNow(now()->addSecond());

    $payment->update([
        'purchase_id' => $secondPurchase->id,
        'amount' => 120,
        'currency' => 'USD',
        'exchange_rate' => 40,
        'igtf_rate' => 0.03,
        'payment_method' => PaymentMethod::Transfer->value,
        'reference_number' => 'TR-1234567890123456',
    ]);

    Carbon::setTestNow();

    expect($firstPurchase->fresh()->updated_at->greaterThan($firstUpdatedAt))->toBeTrue();
    expect($secondPurchase->fresh()->updated_at->greaterThan($secondUpdatedAt))->toBeTrue();
});

it('touches the related purchase when a payment is deleted', function () {
    $purchase = Purchase::factory()->create();
    $payment = Payment::factory()->for($purchase)->create();

    $beforeDelete = $purchase->fresh()->updated_at;

    Carbon::setTestNow(now()->addSecond());

    $payment->delete();

    Carbon::setTestNow();

    expect($purchase->fresh()->updated_at->greaterThan($beforeDelete))->toBeTrue();
});
