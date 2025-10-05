<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Activitylog\LogOptions;

class Saga extends Model
{
    /** @use HasFactory<\Database\Factories\SagaFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'host_district_id',
        'date_start_rs',
        'date_end_rs',
        'date_start_rse',
        'date_end_rse',
        'date_start_rtech_qualification',
        'date_end_rtech_qualification',
        'date_start_rtech_saga',
        'date_end_rtech_saga',
        'date_start_rcom',
        'date_end_rcom',
        'date_start_rc_qualification',
        'date_end_rc_qualification',
        'date_start_rc_saga',
        'date_end_rc_saga',
        'date_start_qr',
        'date_end_qr',
        'date_start_qrr',
        'date_end_qrr',
        'date_start_sr',
        'date_end_sr',
        'date_start_srr',
        'date_end_srr',
        'registration_sport',
        'rs_district_involves',
        'date_start_rs_period',
        'date_end_rs_period',
        'registration_sport_event',
        'rse_district_involves',
        'date_start_rse_period',
        'date_end_rse_period',
        'registration_contingent_qualification',
        'rc_qualification_district_involves',
        'date_start_rc_qualification_period',
        'date_end_rc_qualification_period',
        'registration_contingent_saga',
        'rc_saga_district_involves',
        'date_start_rc_saga_period',
        'date_end_rc_saga_period',
        'registration_qualification_round',
        'qr_district_involves',
        'date_start_qr_period',
        'date_end_qr_period',
        'registration_qualification_round_result',
        'qrr_district_involves',
        'date_start_qrr_period',
        'date_end_qrr_period',
        'registration_saga_round',
        'sr_district_involves',
        'date_start_sr_period',
        'date_end_sr_period',
        'registration_saga_round_result',
        'srr_district_involves',
        'date_start_srr_period',
        'date_end_srr_period',
        'registration_technical_qualification',
        'rtech_qualification_district_involves',
        'date_start_rtech_qualification_period',
        'date_end_rtech_qualification_period',
        'registration_technical_saga',
        'rtech_saga_district_involves',
        'date_start_rtech_saga_period',
        'date_end_rtech_saga_period',
        'registration_commitee',
        'rcom_district_involves',
        'date_start_rcom_period',
        'date_end_rcom_period',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'year' => 'string',
        'host_district_id' => 'integer',
        'date_start_rs' => 'date',
        'date_end_rs' => 'date',
        'date_start_rse' => 'date',
        'date_end_rse' => 'date',
        'date_start_rtech_qualification' => 'date',
        'date_end_rtech_qualification' => 'date',
        'date_start_rtech_saga' => 'date',
        'date_end_rtech_saga' => 'date',
        'date_start_rcom' => 'date',
        'date_end_rcom' => 'date',
        'date_start_rc_qualification' => 'date',
        'date_end_rc_qualification' => 'date',
        'date_start_rc_saga' => 'date',
        'date_end_rc_saga' => 'date',
        'date_start_qr' => 'date',
        'date_end_qr' => 'date',
        'date_start_qrr' => 'date',
        'date_end_qrr' => 'date',
        'date_start_sr' => 'date',
        'date_end_sr' => 'date',
        'date_start_srr' => 'date',
        'date_end_srr' => 'date',
        'registration_sport' => 'string',
        'rs_district_involves' => 'json',
        'date_start_rs_period' => 'date',
        'date_end_rs_period' => 'date',
        'registration_sport_event' => 'string',
        'rse_district_involves' => 'json',
        'date_start_rse_period' => 'date',
        'date_end_rse_period' => 'date',
        'registration_contingent' => 'string',
        'rc_qualification_district_involves' => 'json',
        'date_start_rc_qualification_period' => 'date',
        'date_end_rc_qualification_period' => 'date',
        'registration_contingent_saga' => 'string',
        'rc_saga_district_involves' => 'json',
        'date_start_rc_saga_period' => 'date',
        'date_end_rc_saga_period' => 'date',
        'registration_qualification_round' => 'string',
        'qr_district_involves' => 'json',
        'date_start_qr_period' => 'date',
        'date_end_qr_period' => 'date',
        'registration_qualification_round_result' => 'string',
        'qrr_district_involves' => 'json',
        'date_start_qrr_period' => 'date',
        'date_end_qrr_period' => 'date',
        'registration_saga_round' => 'string',
        'sr_district_involves' => 'json',
        'date_start_sr_period' => 'date',
        'date_end_sr_period' => 'date',
        'registration_saga_round_result' => 'string',
        'srr_district_involves' => 'json',
        'date_start_srr_period' => 'date',
        'date_end_srr_period' => 'date',
        'registration_technical_qualification' => 'string',
        'rtech_qualification_district_involves' => 'json',
        'date_start_rtech_qualification_period' => 'date',
        'date_end_rtech_qualification_period' => 'date',
        'registration_technical_saga' => 'string',
        'rtech_saga_district_involves' => 'json',
        'date_start_rtech_saga_period' => 'date',
        'date_end_rtech_saga_period' => 'date',
        'registration_commitee' => 'string',
        'rcom_district_involves' => 'json',
        'date_start_rcom_period' => 'date',
        'date_end_rcom_period' => 'date',
    ];

    public function scopeCurrentSelected(Builder $query)
    {
        if (!session()->has('event')) {
            abort(401, 'Sila log masuk semula');
        }
        return $query->where('id', '=', session()->get('event')['id']);
    }

    public function districts()
    {
        return $this->belongsToMany(Saga::class, 'saga_districts')->withPivot(['active'])->withTimestamps();
    }

    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'saga_sports')->withPivot(['lelaki', 'wanita', 'total_district_must_join', 'total_sport_event_can_be_played_by_participant', 'image'])->withTimestamps();
    }

    public function sagaSports()
    {
        return $this->hasMany(SagaSport::class);
    }

    public function sagaDistricts()
    {
        return $this->hasMany(SagaDistrict::class);
    }

    public function sagaSportContingentRoles()
    {
        return $this->hasManyThrough(SagaSportContingentRole::class, SagaSport::class);
    }

    public function sagaSportTechnicalRoles()
    {
        return $this->hasManyThrough(SagaSportTechnicalRole::class, SagaSport::class);
    }

    public function sagaCommiteeRoles()
    {
        return $this->hasMany(SagaCommiteeRole::class);
    }

    public function sagaSportGroups()
    {
        return $this->hasManyThrough(SagaSportGroup::class, SagaSport::class);
    }

    public function sagaRegistrationSports()
    {
        return $this->hasMany(SagaRegistrationSport::class);
    }

    public function sagaRegistrationContingentLonglists()
    {
        return $this->hasMany(SagaRegistrationContingentLonglist::class);
    }

    public function hostDistrict()
    {
        return $this->belongsTo(District::class, 'host_district_id');
    }
}
