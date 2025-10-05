<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RegistrationRecordRemark: string implements HasLabel, HasDescription, HasColor, HasIcon
{
    case ADDED = 'ADDED';
    case UPDATED = 'UPDATED';
    case DELETED = 'DELETED';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADDED => 'Didaftarkan',
            self::UPDATED => 'Dikemaskini',
            self::DELETED => 'Dipadam',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::ADDED => 'Didaftarkan',
            self::UPDATED => 'Dikemaskini',
            self::DELETED => 'Dipadam',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADDED => 'primary',
            self::UPDATED => 'blue',
            self::DELETED => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ADDED => 'heroicon-m-plus',
            self::UPDATED => 'heroicon-m-pencil',
            self::DELETED => 'heroicon-m-trash',
        };
    }
}
