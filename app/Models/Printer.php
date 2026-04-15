<?php

namespace App\Models;

use Database\Factories\PrinterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /** @use HasFactory<PrinterFactory> */
    use HasFactory;
}
