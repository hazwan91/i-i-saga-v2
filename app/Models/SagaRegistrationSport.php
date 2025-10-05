<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationSport extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationSportFactory> */
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'saga_sport_id' => 'integer',
        'saga_district_id' => 'integer',
        'lelaki' => 'boolean',
        'wanita' => 'boolean',
    ];

    public function sagaRegistrationSportEvents()
    {
        return $this->hasMany(SagaRegistrationSportEvent::class, 'srs_id');
    }

    public function sagaSport()
    {
        return $this->belongsTo(SagaSport::class);
    }

    public function sagaDistrict()
    {
        return $this->belongsTo(SagaDistrict::class);
    }

    public function sagaRegistrationContingentLonglists()
    {
        return $this->hasMany(SagaRegistrationContingentLonglist::class, 'srs_id');
    }
}
