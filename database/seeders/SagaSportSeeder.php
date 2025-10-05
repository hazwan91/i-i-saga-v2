<?php

namespace Database\Seeders;

use App\Models\Saga;
use App\Models\SagaSport;
use App\Models\Sport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SagaSportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            [
                'name' => 'Angkat Berat',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/1. ANGKAT BERAT.png'),
            ],
            [
                'name' => 'Badminton',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 2,
                'image' => asset('images/pictogram/3 BADMINTON.png'),
            ],
            [
                'name' => 'Berbasikal',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 9,
                'image' => asset('images/pictogram/2. BERBASIKAL.png'),
            ],
            [
                'name' => 'Bola Jaring',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/17. BOLA JARING.png'),
            ],
            [
                'name' => 'Bola Keranjang',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/18. BOLA KERANJANG.png'),
            ],
            [
                'name' => 'Bola Sepak',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/19. BOLA SEPAK.png'),
            ],
            [
                'name' => 'Bola Tampar',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/20. BOLA TAMPAR.png'),
            ],
            [
                'name' => 'Boling Padang',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 2,
                'image' => asset('images/pictogram/12. BOLING PADANG.png'),
            ],
            [
                'name' => 'E-Sports',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/21. ESPORTS.png'),
            ],
            [
                'name' => 'Golf',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 2,
                'image' => asset('images/pictogram/4. GOLF.png'),
            ],
            [
                'name' => 'Hoki',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/7. HOKI.png'),
            ],
            [
                'name' => 'Karate',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 3,
                'image' => asset('images/pictogram/11. KARATE.png'),
            ],
            [
                'name' => 'Kriket',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/25 KRIKET.png'),
            ],
            [
                'name' => 'Memanah',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 4,
                'image' => asset('images/pictogram/5. MEMANAH.png'),
            ],
            [
                'name' => 'Muay',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/22. MUAY.png'),
            ],
            [
                'name' => 'Ping Pong',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 2,
                'image' => asset('images/pictogram/9. PING PONG.png'),
            ],
            [
                'name' => 'Olahraga',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 5,
                'image' => asset('images/pictogram/6. OLAHRAGA.png'),
            ],
            [
                'name' => 'Pencak Silat',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/13. PENCAK SILAT.png'),
            ],
            [
                'name' => 'Petanque',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 3,
                'image' => asset('images/pictogram/23. PETANQUE.png'),
            ],
            [
                'name' => 'Ragbi',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/8. RAGBI.png'),
            ],
            [
                'name' => 'Sepak Takraw',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 3,
                'image' => asset('images/pictogram/14. SEPAK TAKRAW.png'),
            ],
            [
                'name' => 'Taekwando',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/10. TAEKWONDO.png'),
            ],
            [
                'name' => 'Tenis',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 2,
                'image' => asset('images/pictogram/15. TENIS.png'),
            ],
            [
                'name' => 'Tinju',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 1,
                'image' => asset('images/pictogram/24. TINJU.png'),
            ],
            [
                'name' => 'Wushu',
                'total_district_must_join' => 10,
                'total_sport_event_can_be_played_by_participant' => 2,
                'image' => asset('images/pictogram/16. WUSHU.png'),
            ],
        ];
        $saga = Saga::where('year', '2025')->first();
        $arrayInvolveQualificationSaga = [
            'Bola Jaring',
            'Bola Keranjang',
            'Bola Sepak',
            'Bola Tampar',
            'Sepak Takraw',
            'Hoki'
        ];
        $arrayMenOnly = [
            'Tinju'
        ];
        $arrayWomenOnly = [
            'Bola Jaring'
        ];

        foreach ($array as $a) {
            $sport = Sport::with('sportEvents')->where(DB::raw('upper(name)'), 'LIKE', '%' . Str::upper($a['name']) . '%')->first();
            $sagaSport = new SagaSport;
            $sagaSport->saga_id = $saga->id;
            $sagaSport->sport_id = $sport->id;
            if (in_array($a['name'], $arrayInvolveQualificationSaga)) {
                $sagaSport->involve_qualification_round = true;
            }

            if (in_array($a['name'], $arrayMenOnly)) {
                $sagaSport->lelaki = true;
                $sagaSport->wanita = false;
            } elseif (in_array($a['name'], $arrayWomenOnly)) {
                $sagaSport->lelaki = false;
                $sagaSport->wanita = true;
            } else {
                $sagaSport->lelaki = true;
                $sagaSport->wanita = true;
            }
            $sagaSport->total_district_must_join = $a['total_district_must_join'];
            $sagaSport->total_sport_event_can_be_played_by_participant = $a['total_sport_event_can_be_played_by_participant'];
            $sagaSport->image = $a['image'];
            $sagaSport->save();
        }
    }
}
