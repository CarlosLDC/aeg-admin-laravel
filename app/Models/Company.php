<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'legal_name',
        'tax_id',
        'taxpayer_type',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
