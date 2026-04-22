<?php

namespace App\Models;

use App\Enums\DeviceType;
use Database\Factories\PrinterModelFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PrinterModel extends Model
{
    /** @use HasFactory<PrinterModelFactory> */
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'device_type',
        'administrative_act',
        'certification_date',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'device_type' => DeviceType::class,
        ];
    }

    protected function administrative_act(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::upper($value),
        );
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
