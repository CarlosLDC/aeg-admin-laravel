<?php

namespace App\Models;

use Database\Factories\DistributorContactFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class DistributorContact extends Model
{
    /** @use HasFactory<DistributorContactFactory> */
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'name',
        'national_id',
        'phone',
        'email',
    ];

    protected function nationalId(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Str::substrReplace($value, '-', 1, 0),
            set: fn(string $value) => Str::upper($value),
        );
    }

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
