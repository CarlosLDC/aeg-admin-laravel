<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterModel extends Model
{
    /** @use HasFactory<\Database\Factories\PrinterModelFactory> */
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'price',
        'administrative_act',
        'certification_date',
    ];
}
