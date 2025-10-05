<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Accommodation: int implements HasLabel, HasColor, HasIcon
{
    case NEED_ACCOMMODATION = 1;
    case NO_NEED_ACCOMMODATION = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NEED_ACCOMMODATION => 'Perlu Penginapan',
            self::NO_NEED_ACCOMMODATION => 'Tidak Perlu Penginapan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::NEED_ACCOMMODATION => 'blue',
            self::NO_NEED_ACCOMMODATION => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return 'heroicon-m-user';
    }
}
