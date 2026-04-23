<?php

namespace App\Models;

use Database\Factories\ServiceCenterContactFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ServiceCenterContact extends Model
{
    /** @use HasFactory<ServiceCenterContactFactory> */
    use HasFactory;

    protected $fillable = [
        'service_center_id',
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

    public function serviceCenter(): BelongsTo
    {
        return $this->belongsTo(ServiceCenter::class);
    }
}
