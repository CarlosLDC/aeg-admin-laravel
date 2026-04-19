<?php

namespace App\Models;

use Database\Factories\PrinterModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrinterModel extends Model
{
    /** @use HasFactory<PrinterModelFactory> */
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'price',
        'administrative_act',
        'certification_date',
    ];

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
