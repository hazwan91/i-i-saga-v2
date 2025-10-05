<?php

namespace Database\Seeders;

use App\Models\Saga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saga = new Saga;
        $saga->name = "SAGA 2025";
        $saga->year = "2025";
        $saga->date_start_rs = "2025-02-17";
        $saga->date_end_rs = "2025-03-09";
        $saga->date_start_rse = "2025-02-24";
        $saga->date_end_rse = "2025-03-24";
        $saga->date_start_rtech_qualification = "2025-02-24";
        $saga->date_end_rtech_qualification = "2025-05-18";
        $saga->date_start_rtech_saga = "2025-02-24";
        $saga->date_end_rtech_saga = "2025-09-08";
        $saga->date_start_rcom_qualification = "2025-02-24";
        $saga->date_end_rcom_qualification = "2025-05-18";
        $saga->date_start_rcom_saga = "2025-02-24";
        $saga->date_end_rcom_saga = "2025-09-08";
        $saga->date_start_rcl = "2025-03-24";
        $saga->date_end_rcl = "2025-08-09";
        $saga->date_start_rsl = "2025-03-17";
        $saga->date_end_rsl = "2025-08-29";
        $saga->date_start_qr = "2025-06-01";
        $saga->date_end_qr = "2025-06-06";
        $saga->save();
    }
}
