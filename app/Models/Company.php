<?php

namespace App\Models;

use App\Enums\TaxpayerType;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'tax_id',
        'legal_name',
        'taxpayer_type',
    ];

    protected function casts(): array
    {
        return [
            'taxpayer_type' => TaxpayerType::class,
        ];
    }

    protected function tax_id(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->substrReplace('-', 1, 0)->substrReplace('-', -1, 0),
            set: fn (string $value) => Str::of($value)->remove('-')->upper()->toString(),
        );
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
