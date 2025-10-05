<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationSportEvent extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationSportEventFactory> */
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'saga_registration_sport_id' => 'integer',
        'saga_sport_event_id' => 'integer',
        'lelaki' => 'boolean',
        'wanita' => 'boolean',
        'campuran' => 'boolean',
    ];

    public function sagaRegistrationSport()
    {
        return $this->belongsTo(SagaRegistrationSport::class, 'srs_id');
    }

    public function sagaSportEvent()
    {
        return $this->belongsTo(SagaSportEvent::class);
    }
}
