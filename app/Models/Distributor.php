<?php

namespace App\Models;

use App\Filament\Resources\Distributors\Resources\DistributorContracts\Schemas\DistributorContractForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distributor extends Model
{
    /** @use HasFactory<\Database\Factories\DistributorFactory> */
    use HasFactory;

    protected $fillable = [
        'branch_id',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function representatives(): HasMany
    {
        return $this->hasMany(Representative::class);
    }

    public function distributorContracts(): HasMany
    {
        return $this->hasMany(DistributorContract::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
