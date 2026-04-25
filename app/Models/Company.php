<?php

namespace App\Models;

use App\Enums\TaxpayerType;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

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

    protected function taxId(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)
                ->substrReplace('-', 1, 0)
                ->when(
                    in_array($value[0], ['J', 'G', 'C', 'P']),
                    fn (Stringable $string) => $string->substrReplace('-', -1, 0),
                )
                ->toString(),
            set: fn (string $value) => Str::of($value)
                ->substr(1)
                ->padLeft(9, '0')
                ->prepend($value[0])
                ->upper()
                ->toString(),
        );
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function distributors(): HasManyThrough
    {
        return $this->hasManyThrough(Distributor::class, Branch::class);
    }

    public function serviceCenters(): HasManyThrough
    {
        return $this->hasManyThrough(ServiceCenter::class, Branch::class);
    }

    public function softwareProviders(): HasManyThrough
    {
        return $this->hasManyThrough(SoftwareProvider::class, Branch::class);
    }
}
