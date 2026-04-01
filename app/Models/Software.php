<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Software extends Model
{
    /** @use HasFactory<\Database\Factories\SoftwareFactory> */
    use HasFactory;

    protected $fillable = [
        'software_provider_id',
        'name',
        'version',
        'integration_date',
        'operating_systems',
        'programming_languages',
    ];

    protected $casts = [
        'operating_systems' => 'array',
        'programming_languages' => 'array',
    ];

    public function softwareProvider(): BelongsTo
    {
        return $this->belongsTo(SoftwareProvider::class);
    }
}
