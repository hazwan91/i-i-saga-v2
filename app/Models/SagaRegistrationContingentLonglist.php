<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class SagaRegistrationContingentLonglist extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationContingentLonglistFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'saga_registration_sport_id',
        'contingent_role_id',
        'race_id',
        'current_district_id',
        'place_of_birth_id',
        'ic',
        'passport',
        'name',
        'acreditation_name',
        'dob',
        'age',
        'height',
        'weight',
        'is_malaysia',
        'address',
        'house_tel_no',
        'hp_no',
        'sex',
        't_shirt_size',
        'tracksuit_size',
        'shoe_size',
        'saga_involvement',
        'sukma_involvement',
        'highest_involvement_in_sport',
        'achievements',
        'image',
        'ic_image',
        'passport_image',
        'vaccination_image',
        'queried',
        'verified',
        'verified_at',
        'verified_by',
        'reject',
        'reject_remark',
        'rejected_at',
        'rejected_by',
        'shortlist',
    ];

    protected $casts = [
        'id' => 'integer',
        'saga_registration_sport_id' => 'integer',
        'contingent_role_id' => 'integer',
        'race_id' => 'integer',
        'current_district_id' => 'integer',
        'place_of_birth_id' => 'integer',
        'ic' => 'string',
        'passport' => 'string',
        'name' => 'string',
        'acreditation_name' => 'string',
        'dob' => 'date',
        'age' => 'integer',
        'height' => 'string',
        'weight' => 'string',
        'is_malaysia' => 'boolean',
        'address' => 'string',
        'house_tel_no' => 'string',
        'hp_no' => 'string',
        'sex' => 'string',
        't_shirt_size' => 'string',
        'tracksuit_size' => 'string',
        'shoe_size' => 'string',
        'saga_involvement' => 'array',
        'sukma_involvement' => 'array',
        'highest_involvement_in_sport' => 'array',
        'achievements' => 'array',
        'image' => 'string',
        'ic_image' => 'array',
        'passport_image' => 'array',
        'vaccination_image' => 'array',
        'queried' => 'boolean',
        'verified' => 'boolean',
        'verified_at' => 'datetime',
        'verified_by' => 'integer',
        'reject' => 'boolean',
        'reject_remark' => 'string',
        'rejected_at' => 'datetime',
        'rejected_by' => 'integer',
        'shortlist' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaRegistrationSport()
    {
        return $this->belongsTo(SagaRegistrationSport::class);
    }

    public function contingentRole()
    {
        return $this->belongsTo(ContingentRole::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function currentDistrict()
    {
        return $this->belongsTo(District::class, 'current_district_id');
    }

    public function placeOfBirth()
    {
        return $this->belongsTo(District::class, 'place_of_birth_id');
    }

    public function sagaRegistrationContingentQueries()
    {
        return $this->hasMany(SagaRegistrationContingentQuery::class, 'srcl_id');
    }
}
