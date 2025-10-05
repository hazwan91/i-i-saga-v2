<?php

namespace App\Models;

use App\Enums\RegistrationRecordRemark;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationCommiteeRecord extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationCommiteeRecordFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_commitee_id',
        'saga_commitee_role_id',
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
        'saga_registration_commitee_id' => 'integer',
        'saga_commitee_role_id' => 'integer',
        'remark' => RegistrationRecordRemark::class,
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function sagaRegistrationCommitee()
    {
        return $this->belongsTo(SagaRegistrationCommitee::class);
    }

    public function sagaCommiteeRole()
    {
        return $this->belongsTo(SagaCommiteeRole::class);
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
