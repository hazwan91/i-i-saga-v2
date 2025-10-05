<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Pusingan: string implements HasLabel, HasDescription, HasColor, HasIcon
{
    case PUSINGAN_KELAYAKAN = 'PUSINGAN_KELAYAKAN';
    case SAGA = 'SAGA';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PUSINGAN_KELAYAKAN => 'Pusingan Kelayakan',
            self::SAGA => 'Saga',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::PUSINGAN_KELAYAKAN => 'Pusingan Kelayakan',
            self::SAGA => 'Saga',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PUSINGAN_KELAYAKAN => 'blue',
            self::SAGA => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::PUSINGAN_KELAYAKAN => 'heroicon-m-calendar-days',
            self::SAGA => 'heroicon-m-calendar-days',
        };
    }
}
