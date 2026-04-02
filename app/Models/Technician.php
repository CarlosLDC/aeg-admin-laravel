<?php

namespace App\Models;

use Database\Factories\TechnicianFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Technician extends Model
{
    /** @use HasFactory<TechnicianFactory> */
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
