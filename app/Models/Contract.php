<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    /** @use HasFactory<\Database\Factories\ContractFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contractable_id',
        'contractable_type',
        'photo_path',
        'start_date',
        'end_date',
    ];

    public function contractable(): MorphTo
    {
        return $this->morphTo();
    }
}
