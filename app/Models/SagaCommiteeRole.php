<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;

class SagaCommiteeRole extends Model
{
    /** @use HasFactory<\Database\Factories\SagaCommiteeRoleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_id',
        'commitee_role_id',
        'total',
        'participant_dob_year_start',
        'participant_dob_year_end',
        'card_type',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'saga_id' => 'integer',
        'commitee_role_id' => 'integer',
        'total' => 'integer',
        'participant_dob_year_start' => 'string',
        'participant_dob_year_end' => 'string',
        'card_type' => 'string',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereRelation('saga', 'id', '=', session()->get('event')['id']);
        });
    }

    public function commiteeRole()
    {
        return $this->belongsTo(CommiteeRole::class);
    }

    public function saga()
    {
        return $this->belongsTo(Saga::class);
    }

    public function sagaRegistrationCommiteeRoles()
    {
        return $this->hasMany(SagaRegistrationCommiteeRole::class);
    }

    public function registeredAll()
    {
        // return $this->hasManyThrough(
        //     SagaRegistrationCommitee::class,
        //     SagaRegistrationCommiteeRole::class,
        //     'saga_commitee_role_id',
        //     'id',
        //     'id',
        //     'saga_registration_commitee_id'
        // );

        return $this->hasMany(SagaRegistrationCommiteeRole::class);
    }

    public function registeredMen()
    {
        // return $this->hasManyThrough(
        //     SagaRegistrationCommitee::class,
        //     SagaRegistrationCommiteeRole::class,
        //     'saga_commitee_role_id',
        //     'id',
        //     'id',
        //     'saga_registration_commitee_id'
        // )->where('sex', 'LELAKI');
        return $this->hasMany(SagaRegistrationCommiteeRole::class)->where('category', '=', 'MEN');
    }

    public function registeredWomen()
    {
        // return $this->hasManyThrough(
        //     SagaRegistrationCommitee::class,
        //     SagaRegistrationCommiteeRole::class,
        //     'saga_commitee_role_id',
        //     'id',
        //     'id',
        //     'saga_registration_commitee_id'
        // )->where('sex', 'WANITA');
        return $this->hasMany(SagaRegistrationCommiteeRole::class)->where('category', '=', 'WOMEN');
    }

    public function registeredMix()
    {
        // return $this->hasManyThrough(
        //     SagaRegistrationCommitee::class,
        //     SagaRegistrationCommiteeRole::class,
        //     'saga_commitee_role_id',
        //     'id',
        //     'id',
        //     'saga_registration_commitee_id'
        // )->where('sex', 'WANITA');
        return $this->hasMany(SagaRegistrationCommiteeRole::class)->where('category', '=', 'MIX');
    }
}
