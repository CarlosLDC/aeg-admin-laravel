<?php

namespace App\Models;

use App\Enums\VenezuelaState;
use Database\Factories\BranchFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Branch extends Model
{
    /** @use HasFactory<BranchFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'trade_name',
        'city',
        'state',
        'address',
        'phone_primary',
        'phone_secondary',
        'email',
        'contact_person',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'state' => VenezuelaState::class,
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function distributor(): HasOne
    {
        return $this->hasOne(Distributor::class);
    }

    public function serviceCenter(): HasOne
    {
        return $this->hasOne(ServiceCenter::class);
    }

    public function softwareProvider(): HasOne
    {
        return $this->hasOne(SoftwareProvider::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
}
