<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;

class SagaSportTechnicalRole extends Model
{
    /** @use HasFactory<\Database\Factories\SagaSportTechnicalRoleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_sport_id',
        'technical_role_id',
        'pk_total_men',
        'pk_total_women',
        'pk_total_mix',
        'saga_total_men',
        'saga_total_women',
        'saga_total_mix',
        'pk_participant_men_dob_year_start',
        'pk_participant_men_dob_year_end',
        'pk_participant_women_dob_year_start',
        'pk_participant_women_dob_year_end',
        'pk_participant_mix_dob_year_start',
        'pk_participant_mix_dob_year_end',
        'saga_participant_men_dob_year_start',
        'saga_participant_men_dob_year_end',
        'saga_participant_women_dob_year_start',
        'saga_participant_women_dob_year_end',
        'saga_participant_mix_dob_year_start',
        'saga_participant_mix_dob_year_end',
        'involve_qualification_round',
        'qualification_saga_card_type',
        'involve_saga',
        'saga_card_type',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'saga_sport_id' => 'integer',
        'technical_role_id' => 'integer',
        'pk_total_men' => 'integer',
        'pk_total_women' => 'integer',
        'pk_total_mix' => 'integer',
        'saga_total_men' => 'integer',
        'saga_total_women' => 'integer',
        'saga_total_mix' => 'integer',
        'pk_participant_men_dob_year_start' => 'string',
        'pk_participant_men_dob_year_end' => 'string',
        'pk_participant_women_dob_year_start' => 'string',
        'pk_participant_women_dob_year_end' => 'string',
        'pk_participant_mix_dob_year_start' => 'string',
        'pk_participant_mix_dob_year_end' => 'string',
        'saga_participant_men_dob_year_start' => 'string',
        'saga_participant_men_dob_year_end' => 'string',
        'saga_participant_women_dob_year_start' => 'string',
        'saga_participant_women_dob_year_end' => 'string',
        'saga_participant_mix_dob_year_start' => 'string',
        'saga_participant_mix_dob_year_end' => 'string',
        'involve_qualification_round' => 'boolean',
        'qualification_saga_card_type' => 'string',
        'involve_saga' => 'boolean',
        'saga_card_type' => 'string',
        'active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaSport()
    {
        return $this->belongsTo(SagaSport::class);
    }

    public function technicalRole()
    {
        return $this->belongsTo(TechnicalRole::class);
    }

    public function sagaRegistrationTechnicalRoles()
    {
        return $this->hasMany(SagaRegistrationTechnicalRole::class);
    }
}
