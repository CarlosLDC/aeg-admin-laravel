<?php

namespace App\Models;

use App\Enums\PrinterStatus;
use Database\Factories\PrinterFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Printer extends Model
{
    /** @use HasFactory<PrinterFactory> */
    use HasFactory;

    protected $fillable = [
        'fiscal_serial_number',
        'printer_model_id',
        'mac_address',
        'firmware_id',
        'software_id',
        'status',
        'installation_date',
        'client_id',
        'sale_id',
        'final_sale_price',
        'is_paid',
        'headers',
    ];

    protected function casts(): array
    {
        return [
            'status' => PrinterStatus::class,
            'headers' => 'array',
        ];
    }

    protected function fiscal_serial_number(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::upper($value),
        );
    }

    public function printerModel(): BelongsTo
    {
        return $this->belongsTo(PrinterModel::class);
    }

    public function firmware(): BelongsTo
    {
        return $this->belongsTo(Firmware::class);
    }

    public function software(): BelongsTo
    {
        return $this->belongsTo(Software::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function scopeAvailableForSale(Builder $query): Builder
    {
        return $query->whereNull('sale_id');
    }
}
