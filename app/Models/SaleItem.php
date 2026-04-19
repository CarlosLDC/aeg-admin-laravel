<?php

namespace App\Models;

use App\Observers\SaleItemObserver;
use Database\Factories\SaleItemFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(SaleItemObserver::class)]
class SaleItem extends Model
{
    /** @use HasFactory<SaleItemFactory> */
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'printer_model_id',
        'tax_id',
        'quantity',
        'unit_price',
        'discount',
        'applied_tax_rate',
    ];

    public static function booted(): void
    {
        static::saving(function (SaleItem $saleItem) {
            $saleItem->recalculateTotals();
        });
    }

    public function recalculateTotals(): self
    {
        $lineTotal = ($this->quantity * $this->unit_price) - $this->discount;
        $taxAmount = $lineTotal * $this->applied_tax_rate;
        $total = $lineTotal + $taxAmount;

        $this->line_total = round($lineTotal, 2);
        $this->tax_amount = round($taxAmount, 2);
        $this->grand_total = round($total, 2);

        return $this;
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
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
