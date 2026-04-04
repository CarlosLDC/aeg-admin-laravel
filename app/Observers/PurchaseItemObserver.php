<?php

namespace App\Observers;

use App\Models\PurchaseItem;

class PurchaseItemObserver
{
    public function created(PurchaseItem $purchaseItem): void
    {
        $this->updatePurchaseTotals($purchaseItem);
    }

    public function updated(PurchaseItem $purchaseItem): void
    {
        if ($purchaseItem->wasChanged(['quantity', 'unit_price', 'discount', 'applied_tax_rate'])) {
            $this->updatePurchaseTotals($purchaseItem);
        }
    }

    public function deleted(PurchaseItem $purchaseItem): void
    {
        $this->updatePurchaseTotals($purchaseItem);
    }

    public function updatePurchaseTotals(PurchaseItem $purchaseItem): void
    {
        $purchase = $purchaseItem->purchase;

        $purchase->update([
            'total_tax' => $purchase->purchaseItems()->sum('tax_amount'),
            'subtotal' => $purchase->purchaseItems()->sum('line_total'),
        ]);
    }
}
