<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum VenezuelaState: string implements HasLabel
{
    case Amazonas = 'amazonas';
    case Anzoategui = 'anzoategui';
    case Apure = 'apure';
    case Aragua = 'aragua';
    case Barinas = 'barinas';
    case Bolivar = 'bolivar';
    case Carabobo = 'carabobo';
    case Cojedes = 'cojedes';
    case DeltaAmacuro = 'delta_amacuro';
    case DistritoCapital = 'distrito_capital';
    case Falcon = 'falcon';
    case Guarico = 'guarico';
    case Lara = 'lara';
    case Merida = 'merida';
    case Miranda = 'miranda';
    case Monagas = 'monagas';
    case NuevaEsparta = 'nueva_esparta';
    case Portuguesa = 'portuguesa';
    case Sucre = 'sucre';
    case Tachira = 'tachira';
    case Trujillo = 'trujillo';
    case LaGuaira = 'la_guaira';
    case Yaracuy = 'yaracuy';
    case Zulia = 'zulia';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Amazonas => 'Amazonas',
            self::Anzoategui => 'Anzoátegui',
            self::Apure => 'Apure',
            self::Aragua => 'Aragua',
            self::Barinas => 'Barinas',
            self::Bolivar => 'Bolívar',
            self::Carabobo => 'Carabobo',
            self::Cojedes => 'Cojedes',
            self::DeltaAmacuro => 'Delta Amacuro',
            self::DistritoCapital => 'Distrito Capital',
            self::Falcon => 'Falcón',
            self::Guarico => 'Guárico',
            self::Lara => 'Lara',
            self::Merida => 'Mérida',
            self::Miranda => 'Miranda',
            self::Monagas => 'Monagas',
            self::NuevaEsparta => 'Nueva Esparta',
            self::Portuguesa => 'Portuguesa',
            self::Sucre => 'Sucre',
            self::Tachira => 'Táchira',
            self::Trujillo => 'Trujillo',
            self::LaGuaira => 'La Guaira',
            self::Yaracuy => 'Yaracuy',
            self::Zulia => 'Zulia',
        };
    }
}
