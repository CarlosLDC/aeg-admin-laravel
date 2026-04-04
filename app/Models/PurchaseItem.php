<?php

namespace App\Models;

use App\Observers\PurchaseItemObserver;
use Database\Factories\PurchaseItemFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(PurchaseItemObserver::class)]
class PurchaseItem extends Model
{
    /** @use HasFactory<PurchaseItemFactory> */
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'printer_model_id',
        'tax_id',
        'quantity',
        'unit_price',
        'discount',
        'applied_tax_rate',
    ];

    public static function booted(): void
    {
        static::saving(function (PurchaseItem $purchaseItem) {
            $purchaseItem->recalculateTotals();
        });
    }

    public function recalculateTotals(): self
    {
        $lineTotal = ($this->quantity * $this->unit_price) - $this->discount;
        $this->line_total = round($lineTotal, 2);

        $taxAmount = $lineTotal * $this->applied_tax_rate;
        $this->tax_amount = round($taxAmount, 2);

        $this->grand_total = $this->line_total + $this->tax_amount;

        return $this;
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function printerModel(): BelongsTo
    {
        return $this->belongsTo(PrinterModel::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
