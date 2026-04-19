<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Observers\PaymentObserver;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(PaymentObserver::class)]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'amount',
        'currency',
        'exchange_rate',
        'igtf_rate',
        'igtf_amount',
        'total_amount',
        'payment_method',
        'reference_number',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'exchange_rate' => 'decimal:4',
            'igtf_rate' => 'decimal:4',
            'igtf_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'payment_method' => PaymentMethod::class,
            'paid_at' => 'datetime',
        ];
    }

    public static function booted(): void
    {
        static::saving(function (Payment $payment): void {
            $payment->currency = strtoupper($payment->currency ?? 'VES');
            $payment->recalculateTotals();
        });
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function usesForeignCurrency(): bool
    {
        return $this->currency !== 'VES';
    }

    public function recalculateTotals(): self
    {
        $baseAmount = (float) $this->amount;
        $igtfRate = (float) $this->igtf_rate;

        if (! $this->usesForeignCurrency()) {
            $igtfRate = 0;
        }

        $igtfAmount = round($baseAmount * $igtfRate, 2);

        $this->igtf_rate = $igtfRate;
        $this->igtf_amount = $igtfAmount;
        $this->total_amount = round($baseAmount + $igtfAmount, 2);

        return $this;
    }
}
