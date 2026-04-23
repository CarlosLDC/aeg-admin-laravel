<?php

namespace App\Filament\Support;

final class HintIconText
{
    public static function taxId(): string
    {
        return 'Debe comenzar con J, G, C, V, E o P (mayúsculas o minúsculas), sin espacios ni separadores.';
    }

    public static function nationalId(): string
    {
        return 'Debe comenzar con V o E (mayúsculas o minúsculas), sin espacios ni separadores.';
    }
}
