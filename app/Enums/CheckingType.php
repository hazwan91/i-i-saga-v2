<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CheckingType: string implements HasLabel, HasColor, HasIcon
{
    case INDIVIDU = 'INDIVIDU';
    case JAWATAN = 'JAWATAN';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDIVIDU => 'Individu',
            self::JAWATAN => 'Jawatan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INDIVIDU => 'blue',
            self::JAWATAN => 'primary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::INDIVIDU => 'heroicon-m-user',
            self::JAWATAN => 'heroicon-m-check-badge',
        };
    }
}
