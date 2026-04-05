<?php

namespace App\Models;

use Database\Factories\PurchaseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    /** @use HasFactory<PurchaseFactory> */
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'invoice_number',
        'purchase_date',
        'global_discount',
    ];

    public function recalculateTotals(): self
    {
        $subtotal = $this->purchaseItems->sum('line_total');
        $totalTax = $this->purchaseItems->sum('tax_amount');
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

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
