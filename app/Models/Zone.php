<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Zone extends Model
{
    /** @use HasFactory<\Database\Factories\ZoneFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'color' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function sagaRegistrationTechnicalRoles()
    {
        return $this->hasMany(SagaRegistrationTechnicalRole::class);
    }

    public function sagaRegistrationTechnicalSagaTasks()
    {
        return $this->hasMany(SagaRegistrationTechnicalSagaTask::class);
    }
}
