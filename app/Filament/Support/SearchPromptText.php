<?php

namespace App\Filament\Support;

final class SearchPromptText
{
    public static function branchCompanyTaxId(): string
    {
        return 'Buscar por Nombre Comercial, RIF o Razón Social';
    }

    public static function branchCompanyTaxIdWithEllipsis(): string
    {
        return self::branchCompanyTaxId().'...';
    }

    public static function branchCompanyLegalNameTaxId(): string
    {
        return 'Buscar por Nombre Comercial, Razón Social o RIF...';
    }
}
