<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case CashBs = 'efectivo_bs';
    case CashUsd = 'efectivo_usd';
    case Mobile = 'pago_movil';
    case Debit = 'debito';
    case Transfer = 'transferencia';
    case Zelle = 'zelle';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CashBs => 'Efectivo (Bolívares)',
            self::CashUsd => 'Efectivo (Dólares)',
            self::Mobile => 'Pago Móvil',
            self::Debit => 'Punto de Venta / Débito',
            self::Transfer => 'Transferencia Bancaria',
            self::Zelle => 'Zelle',
        };
    }
}
