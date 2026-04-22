<?php

namespace App\Models;

use App\Enums\OperatingSystem;
use App\Enums\ProgrammingLanguage;
use Database\Factories\SoftwareFactory;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Software extends Model
{
    /** @use HasFactory<SoftwareFactory> */
    use HasFactory;

    protected $fillable = [
        'software_provider_id',
        'name',
        'version',
        'integration_date',
        'operating_systems',
        'programming_languages',
    ];

    protected function casts(): array
    {
        return [
            'operating_systems' => AsEnumCollection::of(OperatingSystem::class),
            'programming_languages' => AsEnumCollection::of(ProgrammingLanguage::class),
        ];
    }

    public function softwareProvider(): BelongsTo
    {
        return $this->belongsTo(SoftwareProvider::class);
    }
}
