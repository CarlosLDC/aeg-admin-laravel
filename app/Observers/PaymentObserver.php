<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Purchase;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        $this->updatePurchaseTotals($payment);
    }

    public function updated(Payment $payment): void
    {
        if ($payment->wasChanged(['amount', 'currency', 'exchange_rate', 'igtf_rate', 'igtf_amount', 'total_amount', 'purchase_id'])) {
            $this->updatePurchaseTotals($payment);

            if ($payment->wasChanged('purchase_id')) {
                $this->updatePreviousPurchaseTotals($payment);
            }
        }
    }

    public function deleted(Payment $payment): void
    {
        $this->updatePurchaseTotals($payment);
    }

    private function updatePurchaseTotals(Payment $payment): void
    {
        $purchase = Purchase::query()->find($payment->purchase_id);

        if (! $purchase) {
            return;
        }

        $purchase->recalculateTotals()->save();
        Purchase::query()->whereKey($purchase->getKey())->update([
            'updated_at' => now(),
        ]);
    }

    private function updatePreviousPurchaseTotals(Payment $payment): void
    {
        $oldPurchaseId = $payment->getOriginal('purchase_id');

        if (! $oldPurchaseId) {
            return;
        }

        $oldPurchase = Purchase::query()->find($oldPurchaseId);

        if (! ($oldPurchase instanceof Purchase)) {
            return;
        }

        $oldPurchase->recalculateTotals()->save();
        Purchase::query()->whereKey($oldPurchase->getKey())->update([
            'updated_at' => now(),
        ]);
    }
}
