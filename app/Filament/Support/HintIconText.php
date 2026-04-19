<?php

namespace App\Filament\Support;

final class HintIconText
{
    public static function rif(): string
    {
        return 'El RIF debe comenzar con V, E, J, P o G (en mayúsculas) seguido de 9 dígitos, sin separadores ni espacios. Si tiene menos de 9 dígitos, complete con ceros a la izquierda. Ejemplo: J012345678.';
    }

    public static function nationalId(): string
    {
        return 'Debe comenzar con V o E (en mayúsculas) seguido de 7 u 8 dígitos, sin espacios ni separadores. Ejemplo: V12345678.';
    }
}
