<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareProvider extends Model
{
    /** @use HasFactory<\Database\Factories\SoftwareProviderFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'tax_id',
        'phone',
        'email',
        'contact_person',
    ];
}
