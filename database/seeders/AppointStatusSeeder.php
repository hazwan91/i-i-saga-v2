<?php

namespace Database\Seeders;

use App\Models\AppointStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointStatus = new AppointStatus;
        $appointStatus->code = 1;
        $appointStatus->name = 'TETAP DAN BERPENCEN';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 2;
        $appointStatus->name = 'TETAP DAN TIDAK BERPENCEN';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 3;
        $appointStatus->name = 'SEMENTARA';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 4;
        $appointStatus->name = 'KONTRAK';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 5;
        $appointStatus->name = 'PERCUBAAN';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 6;
        $appointStatus->name = 'MEMANGKU';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 7;
        $appointStatus->name = 'MENANGGU KERJA';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 8;
        $appointStatus->name = 'TUKAR SEMENTARA';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();

        $appointStatus = new AppointStatus;
        $appointStatus->code = 9;
        $appointStatus->name = 'PINJAMAN';
        $appointStatus->created_at = now();
        $appointStatus->updated_at = now();
        $appointStatus->save();
    }
}
