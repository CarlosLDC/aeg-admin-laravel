<?php

namespace App\Models;

use App\Enums\BranchRoles;
use App\Enums\VenezuelaState;
use Database\Factories\BranchFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function casts(): array
    {
        return [
            'state' => VenezuelaState::class,
        ];
    }

    protected function roles(): Attribute
    {
        return Attribute::get(
            function () {
                $roles = [];

                if ($this->distributor()->exists()) {
                    $roles[] = BranchRoles::Distributor->value;
                }

                if ($this->serviceCenter()->exists()) {
                    $roles[] = BranchRoles::ServiceCenter->value;
                }

                if ($this->softwareProvider()->exists()) {
                    $roles[] = BranchRoles::SoftwareProvider->value;
                }

                if ($this->client()->exists()) {
                    $roles[] = BranchRoles::Client->value;
                }

                return $roles;
            },
        );
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
