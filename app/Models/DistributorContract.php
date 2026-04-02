<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributorContract extends Model
{
    /** @use HasFactory<\Database\Factories\DistributorContractFactory> */
    use HasFactory;

    protected $fillable = [
        'distributor_id',
        'photo_path',
        'start_date',
        'end_date',
    ];

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class);
    }
}
