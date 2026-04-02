<?php

namespace App\Models;

use Database\Factories\ServiceCenterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function technicians(): HasMany
    {
        return $this->hasMany(Technician::class);
    }

    public function contracts(): MorphMany
    {
        return $this->morphMany(Contract::class, 'contractable');
    }
}
