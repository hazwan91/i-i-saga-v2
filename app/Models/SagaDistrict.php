<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

use Str;

class SagaDistrict extends Model
{
    /** @use HasFactory<\Database\Factories\SagaDistrictFactory> */
    use HasFactory;

    protected $fillable = [
        'saga_id',
        'district_id',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'saga_id' => 'integer',
        'district_id' => 'integer',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereRelation('saga', 'id', '=', session()->get('event')['id']);
        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => dd($value),
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaRegistrationSports()
    {
        return $this->hasMany(SagaRegistrationSport::class);
    }

    public function sagaRegistrationSportEvents()
    {
        return $this->hasManyThrough(SagaRegistrationSportEvent::class, SagaRegistrationSport::class, null, 'srs_id');
    }

    public function saga()
    {
        return $this->belongsTo(Saga::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
