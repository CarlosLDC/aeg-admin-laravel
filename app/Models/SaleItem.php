<?php

namespace App\Models;

use App\Observers\SaleItemObserver;
use Database\Factories\SaleItemFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

#[ObservedBy(SaleItemObserver::class)]
class SaleItem extends Model
{
    /** @use HasFactory<SaleItemFactory> */
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'printer_id',
        'tax_id',
        'unit_price',
        'discount',
        'applied_tax_rate',
    ];

    public static function booted(): void
    {
        static::saving(function (SaleItem $saleItem) {
            $saleId = $saleItem->sale_id;

            if ($saleId && $saleItem->printer_id) {
                $isAssignedToAnotherSale = Printer::query()
                    ->whereKey($saleItem->printer_id)
                    ->whereNotNull('sale_id')
                    ->where('sale_id', '!=', $saleId)
                    ->exists();

                if ($isAssignedToAnotherSale) {
                    throw ValidationException::withMessages([
                        'printer_id' => 'La impresora seleccionada ya fue asignada a otra venta.',
                    ]);
                }
            }

            $saleItem->recalculateTotals();
        });
    }

    public function recalculateTotals(): self
    {
        $lineTotal = $this->unit_price - $this->discount;
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

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }
}
