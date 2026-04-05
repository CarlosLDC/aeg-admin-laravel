<?php

namespace App\Models;

use App\Enums\ColorPrecinto;
use App\Enums\EstatusPrecinto;
use Database\Factories\PrecintoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Precinto extends Model
{
    /** @use HasFactory<PrecintoFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_impresora',
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
            'color' => ColorPrecinto::class,
            'estatus' => EstatusPrecinto::class,
        ];
    }

    public function impresora(): BelongsTo
    {
        return $this->belongsTo(Impresora::class, 'id_impresora');
    }
}
