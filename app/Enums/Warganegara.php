<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Warganegara: int implements HasLabel, HasColor, HasIcon
{
    case Malaysia = 1;
    case BukanMalaysia = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Malaysia => 'WARGANEGARA MALAYSIA',
            self::BukanMalaysia => 'BUKAN WARGANEGARA MALAYSIA',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Malaysia => 'success',
            self::BukanMalaysia => 'pink',
        };
    }

    public function getIcon(): ?string
    {
        return 'heroicon-m-user';
    }
}
