<?php

namespace App\Models;

use Database\Factories\FirmwareFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firmware extends Model
{
    /** @use HasFactory<FirmwareFactory> */
    use HasFactory;

    protected $fillable = [
        'version',
        'release_date',
        'description',
    ];
}
