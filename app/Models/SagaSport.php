<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;

class SagaSport extends Model
{
    /** @use HasFactory<\Database\Factories\SagaSportFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'saga_id',
        'sport_id',
        'lelaki',
        'wanita',
        'total_district_must_join',
        'total_sport_event_can_be_played_by_participant',
        'participant_men_dob_year_start',
        'participant_men_dob_year_end',
        'participant_women_dob_year_start',
        'participant_women_dob_year_end',
        'involve_qualification_round',
        'image',
        'active',
    ];

    protected $casts = [
        'id' => 'integer',
        'saga_id' => 'integer',
        'sport_id' => 'integer',
        'lelaki' => 'boolean',
        'wanita' => 'boolean',
        'total_district_must_join' => 'integer',
        'total_sport_event_can_be_played_by_participant' => 'integer',
        'participant_men_dob_year_start' => 'string',
        'participant_men_dob_year_end' => 'string',
        'participant_women_dob_year_start' => 'string',
        'participant_women_dob_year_end' => 'string',
        'involve_qualification_round' => 'boolean',
        'image' => 'string',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereRelation('saga', 'id', '=', session()->get('event')['id']);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function saga()
    {
        return $this->belongsTo(Saga::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function sagaSportEvents()
    {
        return $this->hasMany(SagaSportEvent::class);
    }

    public function sagaSportContingentRoles()
    {
        return $this->hasMany(SagaSportContingentRole::class);
    }

    public function sagaSportTechnicalRoles()
    {
        return $this->hasMany(SagaSportTechnicalRole::class);
    }

    public function sagaSportGroups()
    {
        return $this->hasMany(SagaSportGroup::class);
    }

    public function sagaRegistrationSports()
    {
        return $this->hasMany(SagaRegistrationSport::class);
    }

    public function sagaRegistrationSportEvents()
    {
        return $this->hasManyThrough(SagaRegistrationSportEvent::class, SagaRegistrationSport::class);
    }

    public function sagaRegistrationTechnicalRoles()
    {
        return $this->hasManyThrough(SagaRegistrationTechnicalRole::class, SagaSportTechnicalRole::class);
    }
}
