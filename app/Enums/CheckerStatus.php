<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CheckerStatus: string implements HasLabel, HasColor, HasIcon
{
    case DALAM_SEMAKAN = 'DALAM_SEMAKAN';
    case LULUS = 'LULUS';
    case KUIRI = 'KUIRI';
    case TOLAK = 'TOLAK';
    case PENGHANTARAN_SEMULA_DIKUIRI = 'PENGHANTARAN_SEMULA_DIKUIRI';
    case KEMASKINI_SEMULA = 'KEMASKINI_SEMULA';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DALAM_SEMAKAN => 'Dalam Semakan',
            self::LULUS => 'Diluluskan',
            self::KUIRI => 'Dikuiri',
            self::TOLAK => 'Ditolak',
            self::PENGHANTARAN_SEMULA_DIKUIRI => 'Penghantaran semula yang dikuiri',
            self::KEMASKINI_SEMULA => 'Permohonan kemaskini semula maklumat',
        // default => '-'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DALAM_SEMAKAN => 'blue',
            self::LULUS => 'success',
            self::KUIRI => 'warning',
            self::TOLAK => 'danger',
            self::PENGHANTARAN_SEMULA_DIKUIRI => 'blue',
            self::KEMASKINI_SEMULA => 'blue',
        // default => null,
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DALAM_SEMAKAN => 'heroicon-m-clock',
            self::LULUS => 'heroicon-m-hand-thumb-up',
            self::KUIRI => 'heroicon-m-hand-thumb-down',
            self::TOLAK => 'heroicon-m-x-mark',
            self::PENGHANTARAN_SEMULA_DIKUIRI => 'heroicon-m-clock',
            self::KEMASKINI_SEMULA => 'heroicon-m-clock',
        // default => ''
        };
    }
}
