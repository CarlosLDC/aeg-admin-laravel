<?php

namespace App\Models;

use Database\Factories\DistributorContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
