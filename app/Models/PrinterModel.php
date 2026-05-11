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
        // Marca y modelo
        'brand',
        'model',
        // Tipo de dispositivo y precio
        'device_type',
        'price',
        // Información fiscal
        'administrative_act',
        'certification_date',
    ];

    protected function casts(): array
    {
        return [
            'device_type' => DeviceType::class,
        ];
    }

    protected function administrative_act(): Attribute
    {
        return Attribute::set(
            fn (string $value) => Str::upper($value),
        );
    }

    public function printers(): HasMany
    {
        return $this->hasMany(Printer::class);
    }
}
