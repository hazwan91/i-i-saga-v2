<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SagaSportEventContingentRoleGroup extends Model
{
    /** @use HasFactory<\Database\Factories\SagaSportEventContingentRoleGroupFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_sport_event_contingent_role_id',
        'group_name',
        'ordering',
        'total_men',
        'total_women',
        'total_mix',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'saga_sport_event_contingent_role_id' => 'integer',
        'group_name' => 'string',
        'ordering' => 'integer',
        'total_men' => 'integer',
        'total_women' => 'integer',
        'total_mix' => 'integer',
        'active' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereHas('sagaSportEventContingentRole', function ($query) {
                $query->where('active', '=', true);
                $query->whereHas('sagaSportContingentRole', function ($query) {
                    $query->where('active', '=', true);
                    $query->whereHas('sagaSport', function ($query) {
                        $query->where('active', '=', true);
                        $query->whereRelation('saga', 'id', '=', session()->get('event')['id']);
                    });
                });
            });
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaSportEventContingentRole()
    {
        return $this->belongsTo(SagaSportEventContingentRole::class);
    }
}
