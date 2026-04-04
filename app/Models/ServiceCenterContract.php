<?php

namespace App\Models;

use Database\Factories\ServiceCenterContractFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCenterContract extends Model
{
    /** @use HasFactory<ServiceCenterContractFactory> */
    use HasFactory;

    protected $fillable = [
        'service_center_id',
        'photo_path',
        'start_date',
        'end_date',
    ];

    public function serviceCenter(): BelongsTo
    {
        return $this->belongsTo(ServiceCenter::class);
    }
}
