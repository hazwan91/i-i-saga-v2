<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Saga;
use App\Models\SagaDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SagaDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districtWillPlay = ['beaufort', 'beluran', 'kalabakan', 'keningau', 'kinabatangan', 'kota belud', 'kota kinabalu', 'kota marudu', 'kuala penyu', 'kudat', 'kunak', 'lahad datu', 'nabawan', 'papar', 'penampang', 'pitas', 'putatan', 'ranau', 'sandakan', 'semporna', 'sipitang', 'tambunan', 'tawau', 'tenom', 'telupid', 'tongod', 'tuaran'];
        $saga = Saga::where('year', '2025')->first();

        foreach ($districtWillPlay as $district) {
            $districtDb = District::where(DB::raw('upper(name)'), 'LIKE', '%' . Str::upper($district) . '%')->first();

            $sagaDistrict = new SagaDistrict;
            $sagaDistrict->saga_id = $saga->id;
            $sagaDistrict->district_id = $districtDb->id;
            $sagaDistrict->active = true;
            $sagaDistrict->save();
        }
    }
}
