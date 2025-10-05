<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SagaStatus: string implements HasLabel, HasDescription, HasColor, HasIcon
{
    case OPEN_TO_ALL = 'OPEN_TO_ALL';
    case OPEN_TO_SOME_DISTRICT_AND_PERIOD = 'OPEN_TO_SOME_DISTRICT_AND_PERIOD';
    case OPEN_TO_SOME_DISTRICT = 'OPEN_TO_SOME_DISTRICT';
    case OPEN_TO_SOME_PERIOD = 'OPEN_TO_SOME_PERIOD';
    case CLOSE_TO_ALL = 'CLOSE_TO_ALL';
    case CLOSE_TO_SOME_DISTRICT_AND_PERIOD = 'CLOSE_TO_SOME_DISTRICT_AND_PERIOD';
    case CLOSE_TO_SOME_DISTRICT = 'CLOSE_TO_SOME_DISTRICT';
    case CLOSE_TO_SOME_PERIOD = 'CLOSE_TO_SOME_PERIOD';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::OPEN_TO_ALL => 'Buka Untuk Semua',
            self::OPEN_TO_SOME_DISTRICT_AND_PERIOD => 'Buka Kepada Daerah & Tempoh Tertentu',
            self::OPEN_TO_SOME_DISTRICT => 'Buka Kepada Daerah Tertentu',
            self::OPEN_TO_SOME_PERIOD => 'Buka Kepada Tempoh Tertentu',
            self::CLOSE_TO_ALL => 'Tutup Untuk Semua',
            self::CLOSE_TO_SOME_DISTRICT_AND_PERIOD => 'Tutup Kepada Daerah & Tempoh Tertentu',
            self::CLOSE_TO_SOME_DISTRICT => 'Tutup Kepada Daerah Tertentu',
            self::CLOSE_TO_SOME_PERIOD => 'Tutup Kepada Tempoh Tertentu',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::OPEN_TO_ALL => 'Buka Untuk Semua',
            self::OPEN_TO_SOME_DISTRICT_AND_PERIOD => 'Buka Kepada Daerah & Tempoh Tertentu',
            self::OPEN_TO_SOME_DISTRICT => 'Buka Kepada Daerah Tertentu',
            self::OPEN_TO_SOME_PERIOD => 'Buka Kepada Tempoh Tertentu',
            self::CLOSE_TO_ALL => 'Tutup Untuk Semua',
            self::CLOSE_TO_SOME_DISTRICT_AND_PERIOD => 'Tutup Kepada Daerah & Tempoh Tertentu',
            self::CLOSE_TO_SOME_DISTRICT => 'Tutup Kepada Daerah Tertentu',
            self::CLOSE_TO_SOME_PERIOD => 'Tutup Kepada Tempoh Tertentu',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OPEN_TO_ALL => 'primary',
            self::OPEN_TO_SOME_DISTRICT_AND_PERIOD => 'primary',
            self::OPEN_TO_SOME_DISTRICT => 'primary',
            self::OPEN_TO_SOME_PERIOD => 'primary',
            self::CLOSE_TO_ALL => 'primary',
            self::CLOSE_TO_SOME_DISTRICT_AND_PERIOD => 'primary',
            self::CLOSE_TO_SOME_DISTRICT => 'primary',
            self::CLOSE_TO_SOME_PERIOD => 'primary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::OPEN_TO_ALL => 'heroicon-m-user',
            self::OPEN_TO_SOME_DISTRICT_AND_PERIOD => 'heroicon-m-user',
            self::OPEN_TO_SOME_DISTRICT => 'heroicon-m-user',
            self::OPEN_TO_SOME_PERIOD => 'heroicon-m-user',
            self::CLOSE_TO_ALL => 'heroicon-m-user',
            self::CLOSE_TO_SOME_DISTRICT_AND_PERIOD => 'heroicon-m-user',
            self::CLOSE_TO_SOME_DISTRICT => 'heroicon-m-user',
            self::CLOSE_TO_SOME_PERIOD => 'heroicon-m-user',
        };
    }
}
