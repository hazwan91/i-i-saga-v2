<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->role = 'SUPER_ADMIN';
        $user->appoint_status_id = 1;
        $user->type = 'SM2';
        $user->ic = '911025125537';
        $user->name = 'WAN AHMAD HAZWAN BIN AHMAD SUHAINI';
        $user->email = 'hazwan.ahmadsuhaini@gmail.com';
        $user->password = Hash::make('123');
        $user->active = 1;
        $user->save();

        $user = new User;
        $user->role = 'KETUA_TEKNIKAL_DELIGAT';
        $user->appoint_status_id = 1;
        $user->type = 'SM2';
        $user->ic = '880621125761';
        $user->name = 'ZUL FAUZI';
        $user->email = 'zulfauzi@gmail.com';
        $user->password = Hash::make('123');
        $user->active = 1;
        $user->save();
        $user->sports()->attach([1, 2]);

        $user = new User;
        $user->role = 'PEGAWAI_PENGELOLA_DAERAH';
        $user->appoint_status_id = 1;
        $user->type = 'SM2';
        $user->ic = '680827125701';
        $user->name = 'TEST USER 1';
        $user->email = 'testuser1@gmail.com';
        $user->password = Hash::make('123');
        $user->active = 1;
        $user->save();
        $user->districts()->attach([22, 18]);

        $user = new User;
        $user->role = 'MSN';
        $user->appoint_status_id = 1;
        $user->type = 'SM2';
        $user->ic = '870118125167';
        $user->name = 'MUNIR BIN AHMED';
        $user->email = 'Munir.Ahmed@sabah.gov.my';
        $user->password = Hash::make('**123**');
        $user->active = 1;
        $user->save();
    }
}
