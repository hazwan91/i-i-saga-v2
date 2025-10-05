<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class CommiteeRole extends Model
{
    /** @use HasFactory<\Database\Factories\CommiteeRoleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'ordering',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'type' => 'string',
        'ordering' => 'integer',
    ];

    public function sagaCommiteeRoles()
    {
        return $this->hasMany(SagaCommiteeRole::class);
    }

    public function sagaCommiteeRole()
    {
        return $this->hasOne(SagaCommiteeRole::class);
    }
}
