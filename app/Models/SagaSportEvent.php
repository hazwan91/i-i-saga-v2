<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

use Illuminate\Support\Str;

class SagaSportEvent extends Model
{
    /** @use HasFactory<\Database\Factories\SagaSportEventFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'saga_sport_id',
        'sport_event_id',
        'total_district_must_join',
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
        'saga_sport_id' => 'integer',
        'sport_event_id' => 'integer',
        'total_district_must_join' => 'integer',
        'participant_men_dob_year_start' => 'string',
        'participant_men_dob_year_end' => 'string',
        'participant_women_dob_year_start' => 'string',
        'participant_women_dob_year_end' => 'string',
        'involve_qualification_round' => 'boolean',
        'image' => 'array',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereHas('sagaSport', function ($query) {
                $query->whereRelation('saga', 'id', '=', session()->get('event')['id']);
            });
        });
    }

    // protected $appends = ['sportName'];

    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(string $value) => dd($value),
    //     );
    // }

    // protected function sportName(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(string $value) => dd($value),
    //     );
    // }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaRegistrationSportEvents()
    {
        return $this->hasMany(SagaRegistrationSportEvent::class);
    }

    public function sagaSportEventGroups()
    {
        return $this->hasMany(SagaSportEventGroup::class);
    }

    public function sagaSport()
    {
        return $this->belongsTo(SagaSport::class);
    }

    public function sportEvent()
    {
        return $this->belongsTo(SportEvent::class);
    }

    public function sagaSportEventContingentRoles()
    {
        return $this->hasMany(SagaSportEventContingentRole::class);
    }
}
