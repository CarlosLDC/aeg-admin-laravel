<?php

namespace App\Models;

use Database\Factories\SoftwareProviderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoftwareProvider extends Model
{
    /** @use HasFactory<SoftwareProviderFactory> */
    use HasFactory;

    protected $fillable = [
        'branch_id',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function software(): HasMany
    {
        return $this->hasMany(Software::class);
    }
}
