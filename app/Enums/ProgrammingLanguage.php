<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProgrammingLanguage: string implements HasLabel
{
    case VisualBasic = 'visual_basic';
    case cSharp = 'c_sharp';
    case Java = 'java';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::VisualBasic => 'Visual Basic',
            self::cSharp => 'C#',
            self::Java => 'Java',
        };
    }
}
