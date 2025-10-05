<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class SagaRegistrationTechnicalTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_technical_id',
        'zone_id',
        'technical_role_id',
        'saga_type',
        'catatan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'saga_registration_technical_id' => 'integer',
        'zone_id' => 'integer',
        'technical_role_id' => 'integer',
        'saga_type' => 'string',
        'catatan' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaRegistrationTechnical()
    {
        return $this->belongsTo(SagaRegistrationTechnical::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function technicalRole()
    {
        return $this->belongsTo(TechnicalRole::class);
    }
}
