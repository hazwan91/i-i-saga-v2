<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SagaRegistrationContingentQuery extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationContingentQueryFactory> */
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'srcl_id' => 'integer',
        'query_by_id' => 'integer',
        'query_remark' => 'string',
        'query_resubmit_at' => 'datetime',
    ];

    public function sagaRegistrationContingentLonglist()
    {
        return $this->belongsTo(SagaRegistrationContingentLonglist::class, 'srcl_id');
    }
}
