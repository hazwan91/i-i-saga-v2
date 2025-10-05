<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class SagaRegistrationTechnicalSagaTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_technical_saga_id',
        'zone_id',
        'technical_role_id',
        'catatan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'saga_registration_technical_saga_id' => 'integer',
        'zone_id' => 'integer',
        'technical_role_id' => 'integer',
        'catatan' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaRegistrationTechnicalSaga()
    {
        return $this->belongsTo(SagaRegistrationTechnicalSaga::class);
    }

    public function technicalRole()
    {
        return $this->belongsTo(TechnicalRole::class);
    }
}
