<?php

namespace App\Models;

use Database\Factories\RepresentativeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Representative extends Model
{
    /** @use HasFactory<RepresentativeFactory> */
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
