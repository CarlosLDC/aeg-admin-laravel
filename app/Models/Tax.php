<?php

namespace App\Models;

use Database\Factories\TaxFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends Model
{
    /** @use HasFactory<TaxFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'is_active',
    ];

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
