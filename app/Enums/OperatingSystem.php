<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OperatingSystem: string implements HasLabel
{
    case Windows = 'windows';
    case Linux = 'linux';
    case macOS = 'macos';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Windows => 'Windows',
            self::Linux => 'Linux',
            self::macOS => 'macOS',
        };
    }
}
