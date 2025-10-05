<?php

namespace App\Models;

use App\Enums\CheckingType;
use App\Enums\Pusingan;
use App\Enums\RegistrationCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationTechnicalRole extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationTechnicalRoleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_technical_id',
        'saga_sport_technical_role_id',
        'zone_id',
        'event_type',
        'category',
        'need_accommodation',
        'remark',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'saga_registration_technical_id' => 'integer',
        'saga_sport_technical_role_id' => 'integer',
        'zone_id' => 'integer',
        'event_type' => Pusingan::class,
        'category' => RegistrationCategory::class,
        'need_accommodation' => 'boolean',
        'remark' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereHas('sagaSportTechnicalRole', function (Builder $builder) {
                $builder->whereHas('sagaSport', function (Builder $builder) {
                    $builder->whereRelation('saga', 'id', '=', session()->get('event')['id']);
                });
            });
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaRegistrationTechnical()
    {
        return $this->belongsTo(SagaRegistrationTechnical::class);
    }

    public function sagaSportTechnicalRole()
    {
        return $this->belongsTo(SagaSportTechnicalRole::class);
    }

    public function sagaRegistrationTechnicalStatuses()
    {
        return $this->hasMany(SagaRegistrationTechnicalStatus::class)->where('type', CheckingType::JAWATAN);
    }

    public function sagaRegistrationTechnicalStatusLatest()
    {
        return $this->hasOne(SagaRegistrationTechnicalStatus::class)
            ->latestOfMany('id')
            ->where('type', CheckingType::JAWATAN);
    }

    public function sagaRegistrationTechnicalStatusJawatanLatest()
    {
        return $this->hasOne(SagaRegistrationTechnicalStatus::class)
            ->latestOfMany('id')
            ->where('type', CheckingType::JAWATAN);
    }

    public function sagaRegistrationTechnicalStatusIndividuLatest()
    {
        return $this->hasOne(SagaRegistrationTechnicalStatus::class)
            ->latestOfMany('id')
            ->where('type', CheckingType::INDIVIDU);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
