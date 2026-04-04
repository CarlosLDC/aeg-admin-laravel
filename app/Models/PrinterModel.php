<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrinterModel extends Model
{
    /** @use HasFactory<\Database\Factories\PrinterModelFactory> */
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'price',
        'administrative_act',
        'certification_date',
    ];

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
