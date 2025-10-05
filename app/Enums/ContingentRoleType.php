<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ContingentRoleType: string implements HasLabel, HasDescription, HasColor, HasIcon
{
    case ATLET = 'ATLET';
    case PEGAWAI_KONTINJEN = 'PEGAWAI_KONTINJEN';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ATLET => 'Atlet',
            self::PEGAWAI_KONTINJEN => 'Pegawai Kontinjen',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::ATLET => 'Atlet',
            self::PEGAWAI_KONTINJEN => 'Pegawai Kontinjen',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ATLET => 'danger',
            self::PEGAWAI_KONTINJEN => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ATLET => 'heroicon-m-user',
            self::PEGAWAI_KONTINJEN => 'heroicon-m-user',
        };
    }
}
