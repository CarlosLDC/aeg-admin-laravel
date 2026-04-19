<?php

use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(LazilyRefreshDatabase::class);

it('recalculates payment totals when it is saved', function () {
    $sale = Sale::factory()->create();

    Payment::create([
        'sale_id' => $sale->id,
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

it('touches the related sales when a payment is moved to another sale', function () {
    $firstSale = Sale::factory()->create();
    $secondSale = Sale::factory()->create();

    $payment = Payment::factory()->for($firstSale)->create();

    $firstUpdatedAt = $firstSale->fresh()->updated_at;
    $secondUpdatedAt = $secondSale->fresh()->updated_at;

    Carbon::setTestNow(now()->addSecond());

    $payment->update([
        'sale_id' => $secondSale->id,
        'amount' => 120,
        'currency' => 'USD',
        'exchange_rate' => 40,
        'igtf_rate' => 0.03,
        'payment_method' => PaymentMethod::Transfer->value,
        'reference_number' => 'TR-1234567890123456',
    ]);

    Carbon::setTestNow();

    expect($firstSale->fresh()->updated_at->greaterThan($firstUpdatedAt))->toBeTrue();
    expect($secondSale->fresh()->updated_at->greaterThan($secondUpdatedAt))->toBeTrue();
});

it('touches the related sale when a payment is deleted', function () {
    $sale = Sale::factory()->create();
    $payment = Payment::factory()->for($sale)->create();

    $beforeDelete = $sale->fresh()->updated_at;

    Carbon::setTestNow(now()->addSecond());

    $payment->delete();

    Carbon::setTestNow();

    expect($sale->fresh()->updated_at->greaterThan($beforeDelete))->toBeTrue();
});
