<?php

namespace App\Models;

use Database\Factories\ServiceCenterContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function serviceCenter(): BelongsTo
    {
        return $this->belongsTo(ServiceCenter::class);
    }
}
