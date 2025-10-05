<?php

namespace App\Models;

use App\Enums\CheckerStatus;
use App\Enums\CheckingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationTechnicalStatus extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationTechnicalStatusFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_technical_id',
        'saga_registration_technical_role_id',
        'type',
        'status',
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
        'saga_registration_technical_role_id' => 'integer',
        'type' => CheckingType::class,
        'status' => CheckerStatus::class,
        'remark' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function sagaRegistrationTechnical()
    {
        return $this->belongsTo(SagaRegistrationTechnical::class);
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
