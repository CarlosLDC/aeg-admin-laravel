<?php

namespace App\Models;

use App\Enums\DeviceType;
use App\Enums\PrinterStatus;
use Database\Factories\ImpresoraFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Impresora extends Model
{
    /** @use HasFactory<ImpresoraFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_modelo_impresora',
        'id_software',
        'id_compra',
        'id_sucursal',
        'serial_fiscal',
        'precio_venta_final',
        'estatus',
        'id_firmware',
        'id_distribuidora',
        'se_pago',
        'fecha_instalacion',
        'direccion_mac',
        'tipo_dispositivo',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'precio_venta_final' => 'decimal:2',
            'estatus' => PrinterStatus::class,
            'se_pago' => 'boolean',
            'fecha_instalacion' => 'datetime',
            'tipo_dispositivo' => DeviceType::class,
            'created_at' => 'datetime',
        ];
    }

    public function printerModel(): BelongsTo
    {
        return $this->belongsTo(PrinterModel::class, 'id_modelo_impresora');
    }

    public function software(): BelongsTo
    {
        return $this->belongsTo(Software::class, 'id_software');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'id_compra');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'id_sucursal');
    }

    public function firmware(): BelongsTo
    {
        return $this->belongsTo(Firmware::class, 'id_firmware');
    }

    public function distributor(): BelongsTo
    {
        return $this->belongsTo(Distributor::class, 'id_distribuidora');
    }
}
