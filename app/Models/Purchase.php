<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PaymentTerm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'purchase_date',
        'subtotal',
        'discount',
        'tax',
        'payment_term',
        'payment_status',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'payment_term' => PaymentTerm::class,
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
