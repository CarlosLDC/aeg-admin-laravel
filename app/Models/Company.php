<?php

namespace App\Models;

use App\Enums\TaxpayerType;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'tax_id',
        'legal_name',
        'taxpayer_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'taxpayer_type' => TaxpayerType::class,
        ];
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
