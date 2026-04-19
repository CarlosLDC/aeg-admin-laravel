<?php

namespace App\Observers;

use App\Models\SaleItem;

class SaleItemObserver
{
    public function created(SaleItem $saleItem): void
    {
        $this->updateSaleTotals($saleItem);
    }

    public function updated(SaleItem $saleItem): void
    {
        if ($saleItem->wasChanged(['quantity', 'unit_price', 'discount', 'applied_tax_rate'])) {
            $this->updateSaleTotals($saleItem);
        }
    }

    public function deleted(SaleItem $saleItem): void
    {
        $this->updateSaleTotals($saleItem);
    }

    public function updateSaleTotals(SaleItem $saleItem): void
    {
        $saleItem->sale->recalculateTotals()->save();
    }
}
