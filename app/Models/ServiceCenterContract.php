<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCenterContract extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceCenterContractFactory> */
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
