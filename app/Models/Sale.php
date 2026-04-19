<?php

namespace App\Models;

use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    /** @use HasFactory<SaleFactory> */
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'invoice_number',
        'sale_date',
        'global_discount',
    ];

    public function recalculateTotals(): self
    {
        $subtotal = $this->saleItems->sum('line_total');
        $totalTax = $this->saleItems->sum('tax_amount');
        $total = $subtotal + $totalTax - $this->global_discount;

        $this->subtotal = round($subtotal, 2);
        $this->total_tax = round($totalTax, 2);
        $this->total = round($total, 2);

        return $this;
    }

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
