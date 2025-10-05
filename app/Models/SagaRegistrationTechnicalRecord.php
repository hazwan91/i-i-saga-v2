<?php

namespace App\Models;

use App\Enums\RegistrationRecordRemark;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationTechnicalRecord extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationTechnicalRecordFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_technical_id',
        'saga_sport_technical_role_id',
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
        'remark' => RegistrationRecordRemark::class,
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function sagaRegistrationTechnical()
    {
        return $this->belongsTo(SagaRegistrationTechnical::class);
    }

    public function sagaSportTechnicalRole()
    {
        return $this->belongsTo(SagaSportTechnicalRole::class);
    }
}
