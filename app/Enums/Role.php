<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Str;

enum Role: string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case ADMIN = 'ADMIN';
    case KETUA_PENYELARAS_ZON = 'KETUA_PENYELARAS_ZON';
    case PENYELARAS_ZON = 'PENYELARAS_ZON';
    case MSN = 'MSN';
    case URUSETIA_PELAKSANA = 'URUSETIA_PELAKSANA';
    case VIP = 'VIP';
    case KBSS = 'KBSS';
    case KETUA_TEKNIKAL_DELIGAT = 'KETUA_TEKNIKAL_DELIGAT';
    case PEGAWAI_TEKNIKAL_SUKAN = 'PEGAWAI_TEKNIKAL_SUKAN';
    case PEGAWAI_DAERAH = 'PEGAWAI_DAERAH';
    case PEGAWAI_PENGELOLA_DAERAH = 'PEGAWAI_PENGELOLA_DAERAH';
    case PEMBANTU_PENGELOLA_DAERAH = 'PEMBANTU_PENGELOLA_DAERAH';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => Str::upper('Super Admin'),
            self::ADMIN => Str::upper('Admin'),
            self::KETUA_PENYELARAS_ZON => Str::upper('Ketua Penyelaras Zon'),
            self::PENYELARAS_ZON => Str::upper('Penyelaras Zon'),
            self::MSN => Str::upper('Majlis Sukan Negeri'),
            self::URUSETIA_PELAKSANA => Str::upper('Urusetia Pelaksana'),
            self::VIP => Str::upper('VIP'),
            self::KBSS => Str::upper('Kementerian Belia Dan Sukan'),
            self::KETUA_TEKNIKAL_DELIGAT => Str::upper('Ketua Teknikal Deligat'),
            self::PEGAWAI_TEKNIKAL_SUKAN => Str::upper('Pegawai Teknikal Sukan'),
            self::PEGAWAI_DAERAH => Str::upper('Pegawai Daerah'),
            self::PEGAWAI_PENGELOLA_DAERAH => Str::upper('Pegawai Pengelola Daerah'),
            self::PEMBANTU_PENGELOLA_DAERAH => Str::upper('Pembantu Pengelola Daerah'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::KETUA_PENYELARAS_ZON => 'Ketua Penyelaras Zon',
            self::PENYELARAS_ZON => 'Penyelaras Zon',
            self::MSN => 'Majlis Sukan Negeri',
            self::URUSETIA_PELAKSANA => 'Urusetia Pelaksana',
            self::VIP => 'VIP',
            self::KBSS => 'Kementerian Belia Dan Sukan',
            self::KETUA_TEKNIKAL_DELIGAT => 'Ketua Teknikal Deligat',
            self::PEGAWAI_TEKNIKAL_SUKAN => 'Pegawai Teknikal Sukan',
            self::PEGAWAI_DAERAH => 'Pegawai Daerah',
            self::PEGAWAI_PENGELOLA_DAERAH => 'Pegawai Pengelola Daerah',
            self::PEMBANTU_PENGELOLA_DAERAH => 'Pembantu Pengelola Daerah',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SUPER_ADMIN => 'primary',
            self::ADMIN => 'primary',
            self::KETUA_PENYELARAS_ZON => 'primary',
            self::PENYELARAS_ZON => 'primary',
            self::MSN => 'primary',
            self::URUSETIA_PELAKSANA => 'primary',
            self::VIP => 'primary',
            self::KBSS => 'primary',
            self::KETUA_TEKNIKAL_DELIGAT => 'primary',
            self::PEGAWAI_TEKNIKAL_SUKAN => 'primary',
            self::PEGAWAI_DAERAH => 'primary',
            self::PEGAWAI_PENGELOLA_DAERAH => 'primary',
            self::PEMBANTU_PENGELOLA_DAERAH => 'primary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'heroicon-m-user',
            self::ADMIN => 'heroicon-m-user',
            self::KETUA_PENYELARAS_ZON => 'heroicon-m-user',
            self::PENYELARAS_ZON => 'heroicon-m-user',
            self::MSN => 'heroicon-m-user',
            self::URUSETIA_PELAKSANA => 'heroicon-m-user',
            self::VIP => 'heroicon-m-user',
            self::KBSS => 'heroicon-m-user',
            self::KETUA_TEKNIKAL_DELIGAT => 'heroicon-m-user',
            self::PEGAWAI_TEKNIKAL_SUKAN => 'heroicon-m-user',
            self::PEGAWAI_DAERAH => 'heroicon-m-user',
            self::PEGAWAI_PENGELOLA_DAERAH => 'heroicon-m-user',
            self::PEMBANTU_PENGELOLA_DAERAH => 'heroicon-m-user',
        };
    }
}
