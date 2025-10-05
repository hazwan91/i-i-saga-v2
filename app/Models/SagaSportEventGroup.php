<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

use Illuminate\Support\Str;

class SagaSportEventGroup extends Model
{
    /** @use HasFactory<\Database\Factories\SagaSportEventGroupFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_sport_event_id',
        'group_name',
        'group_order',
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
        'saga_sport_event_id' => 'integer',
        'group_name' => 'string',
        'group_order' => 'integer',
        'total_men' => 'integer',
        'total_women' => 'integer',
        'total_mix' => 'integer',
        'active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaSportEvent()
    {
        return $this->belongsTo(SagaSportEvent::class);
    }
}
