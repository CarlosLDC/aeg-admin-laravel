<?php

namespace App\Models;

use App\Enums\ColorPrecint;
use App\Enums\EstatusPrecint;
use Database\Factories\PrecintFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Precint extends Model
{
    /** @use HasFactory<PrecintFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_printer',
        'serial',
        'created_at',
        'fecha_instalacion',
        'fecha_retiro',
        'color',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'fecha_instalacion' => 'datetime',
            'fecha_retiro' => 'datetime',
            'color' => ColorPrecint::class,
            'estatus' => EstatusPrecint::class,
        ];
    }

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class, 'id_printer');
    }
}
