<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class TechnicalRole extends Model
{
    /** @use HasFactory<\Database\Factories\TechnicalRoleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'ordering',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'type' => 'string',
        'ordering' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaSportTechnicalRoles()
    {
        return $this->hasMany(SagaSportTechnicalRole::class);
    }

    public function sagaRegistrationTechnicalTasks()
    {
        return $this->hasMany(SagaRegistrationTechnicalTask::class);
    }
}
