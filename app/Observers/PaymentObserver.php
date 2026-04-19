<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Sale;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        $this->updateSaleTotals($payment);
    }

    public function updated(Payment $payment): void
    {
        if ($payment->wasChanged(['amount', 'currency', 'exchange_rate', 'igtf_rate', 'igtf_amount', 'total_amount', 'sale_id'])) {
            $this->updateSaleTotals($payment);

            if ($payment->wasChanged('sale_id')) {
                $this->updatePreviousSaleTotals($payment);
            }
        }
    }

    public function deleted(Payment $payment): void
    {
        $this->updateSaleTotals($payment);
    }

    private function updateSaleTotals(Payment $payment): void
    {
        $sale = Sale::query()->find($payment->sale_id);

        if (! $sale) {
            return;
        }

        $sale->recalculateTotals()->save();
        Sale::query()->whereKey($sale->getKey())->update([
            'updated_at' => now(),
        ]);
    }

    private function updatePreviousSaleTotals(Payment $payment): void
    {
        $oldSaleId = $payment->getOriginal('sale_id');

        if (! $oldSaleId) {
            return;
        }

        $oldSale = Sale::query()->find($oldSaleId);

        if (! ($oldSale instanceof Sale)) {
            return;
        }

        $oldSale->recalculateTotals()->save();
        Sale::query()->whereKey($oldSale->getKey())->update([
            'updated_at' => now(),
        ]);
    }
}
