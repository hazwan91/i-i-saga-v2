<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;

class SportEvent extends Model
{
    /** @use HasFactory<\Database\Factories\SportEventFactory> */
    use HasFactory;

    protected $fillable = [
        'sport_id',
        'name',
        'default_image',
    ];

    protected $casts = [
        'id' => 'integer',
        'sport_id' => 'integer',
        'name' => 'string',
        'default_image' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function sagaSportEvent()
    {
        return $this->hasOne(SagaSportEvent::class);
    }

    public function sagaSportEvents()
    {
        return $this->hasMany(SagaSportEvent::class);
    }

    public function scopeFilterByRoleForCurrentSaga(Builder $query, $saga_id, $sport_id)
    {
        $role = Auth::user()->role;
        if (in_array($role, ['SUPER_ADMIN', 'ADMIN'])) {
            $query->whereHas('sagaSportEvents', function ($query) use ($saga_id, $sport_id) {
                return $query->whereHas('sagaSport', function ($query) use ($saga_id, $sport_id) {
                    return $query->where('saga_id', $saga_id)->whereHas('sport', function ($query) use ($sport_id) {
                        $query->where('id', $sport_id);
                    });
                });
            });
        } elseif (in_array($role, ['KETUA_PENYELARAS_ZON', 'PENYELARAS_ZON'])) {
            $query->whereHas('sagaSports', function ($query) use ($saga_id) {
                return $query->where('saga_id', $saga_id);
            })->whereHas('users', function ($query) {
                return $query->where('users.id', '=', Auth::user()->id);
            });
        } else {
            $query->whereHas('sagaSports', function ($query) use ($saga_id) {
                return $query->where('saga_id', $saga_id)
                    ->whereHas('sagaRegistrationSports', function ($query) {
                        return $query->whereHas('sagaDistrict', function ($query) {
                            return $query->whereHas('district', function ($query) {
                                return $query->whereHas('users', function ($query) {
                                    return $query->where('users.id', '=', Auth::user()->id);
                                });
                            });
                        });
                    });
            });
        }
    }
}
