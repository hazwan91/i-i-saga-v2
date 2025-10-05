<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SagaRoleGroup: string implements HasLabel, HasDescription, HasColor, HasIcon
{
    case ATLET = 'ATLET';
    case PEGAWAI_KONTINJEN = 'PEGAWAI_KONTINJEN';
    case PEGAWAI_TEKNIKAL = 'PEGAWAI_TEKNIKAL';
    case JAWATANKUASA_PELAKSANA = 'JAWATANKUASA_PELAKSANA';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ATLET => 'Atlet',
            self::PEGAWAI_KONTINJEN => 'Pegawai Kontinjen',
            self::PEGAWAI_TEKNIKAL => 'Pegawai Teknikal',
            self::JAWATANKUASA_PELAKSANA => 'Jawatankuasa Pelaksana',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::ATLET => 'Atlet',
            self::PEGAWAI_KONTINJEN => 'Pegawai Kontinjen',
            self::PEGAWAI_TEKNIKAL => 'Pegawai Teknikal',
            self::JAWATANKUASA_PELAKSANA => 'Jawatankuasa Pelaksana',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ATLET => 'danger',
            self::PEGAWAI_KONTINJEN => 'danger',
            self::PEGAWAI_TEKNIKAL => 'danger',
            self::JAWATANKUASA_PELAKSANA => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ATLET => 'heroicon-m-user',
            self::PEGAWAI_KONTINJEN => 'heroicon-m-user',
            self::PEGAWAI_TEKNIKAL => 'heroicon-m-user',
            self::JAWATANKUASA_PELAKSANA => 'heroicon-m-user',
        };
    }
}
