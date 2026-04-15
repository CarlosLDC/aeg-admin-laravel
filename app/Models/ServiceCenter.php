<?php

namespace App\Models;

use Database\Factories\ServiceCenterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCenter extends Model
{
    /** @use HasFactory<ServiceCenterFactory> */
    use HasFactory;

    protected $fillable = [
        'branch_id',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function ServiceCenterContacts(): HasMany
    {
        return $this->hasMany(ServiceCenterContact::class);
    }

    public function serviceCenterContracts(): HasMany
    {
        return $this->hasMany(ServiceCenterContract::class);
    }
}
