<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum RegistrationCategory: string implements HasLabel, HasDescription, HasColor, HasIcon
{
    case LELAKI = 'LELAKI';
    case WANITA = 'WANITA';
    case CAMPURAN = 'CAMPURAN';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LELAKI => Str::upper('Lelaki'),
            self::WANITA => Str::upper('Wanita'),
            self::CAMPURAN => Str::upper('Campuran'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::LELAKI => Str::upper('Lelaki'),
            self::WANITA => Str::upper('Wanita'),
            self::CAMPURAN => Str::upper('Campuran'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::LELAKI => 'blue',
            self::WANITA => 'pink',
            self::CAMPURAN => 'purple',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::LELAKI => 'heroicon-m-user',
            self::WANITA => 'heroicon-m-user',
            self::CAMPURAN => 'heroicon-m-users',
        };
    }
}
