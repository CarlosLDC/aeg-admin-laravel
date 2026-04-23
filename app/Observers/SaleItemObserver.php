<?php

namespace App\Observers;

use App\Models\Printer;
use App\Models\SaleItem;

class SaleItemObserver
{
    public function created(SaleItem $saleItem): void
    {
        $this->syncAssignedPrinter($saleItem);
        $this->updateSaleTotals($saleItem);
    }

    public function updated(SaleItem $saleItem): void
    {
        if ($saleItem->wasChanged('printer_id')) {
            $this->releasePrinter((int) $saleItem->getOriginal('printer_id'));
            $this->syncAssignedPrinter($saleItem);
        }

        if ($saleItem->wasChanged(['unit_price', 'discount', 'applied_tax_rate'])) {
            $this->syncAssignedPrinter($saleItem);
            $this->updateSaleTotals($saleItem);
        }
    }

    public function deleted(SaleItem $saleItem): void
    {
        $this->releasePrinter($saleItem->printer_id);
        $this->updateSaleTotals($saleItem);
    }

    public function updateSaleTotals(SaleItem $saleItem): void
    {
        $saleItem->sale->recalculateTotals()->save();
    }

    private function syncAssignedPrinter(SaleItem $saleItem): void
    {
        if (! $saleItem->printer_id || ! $saleItem->sale_id) {
            return;
        }

        Printer::query()
            ->whereKey($saleItem->printer_id)
            ->update([
                'sale_id' => $saleItem->sale_id,
                'final_sale_price' => $saleItem->unit_price,
            ]);
    }

    private function releasePrinter(?int $printerId): void
    {
        if (! $printerId) {
            return;
        }

        Printer::query()
            ->whereKey($printerId)
            ->update([
                'sale_id' => null,
                'final_sale_price' => null,
            ]);
    }
}
