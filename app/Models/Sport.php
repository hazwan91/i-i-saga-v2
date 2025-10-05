<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;

class Sport extends Model
{
    /** @use HasFactory<\Database\Factories\SportFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'default_image',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'default_image' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    // public function scopeFilterByRoleForCurrentSaga(Builder $query, $saga_id)
    // {
    //     $role = Auth::user()->role;
    //     if (in_array($role, ['SUPER_ADMIN', 'ADMIN'])) {
    //         $query->whereHas('sagaSports', function ($query) use ($saga_id) {
    //             return $query->where('saga_id', $saga_id);
    //         });
    //     } elseif (in_array($role, ['KETUA_PENYELARAS_ZON', 'PENYELARAS_ZON'])) {
    //         $query->whereHas('sagaSports', function ($query) use ($saga_id) {
    //             return $query->where('saga_id', $saga_id);
    //         })->whereHas('users', function ($query) {
    //             return $query->where('users.id', '=', Auth::user()->id);
    //         });
    //     } else {
    //         $query->whereHas('sagaSports', function ($query) use ($saga_id) {
    //             return $query->where('saga_id', $saga_id)
    //                 ->whereHas('sagaRegistrationSports', function ($query) {
    //                     return $query->whereHas('sagaDistrict', function ($query) {
    //                         return $query->whereHas('district', function ($query) {
    //                             return $query->whereHas('users', function ($query) {
    //                                 return $query->where('users.id', '=', Auth::user()->id);
    //                             });
    //                         });
    //                     });
    //                 });
    //         });
    //     }
    // }

    public function sportEvents()
    {
        return $this->hasMany(SportEvent::class);
    }

    public function sagas()
    {
        return $this->belongsToMany(Saga::class, 'saga_districts')->withPivot(['lelaki', 'wanita', 'total_district_must_join', 'total_sport_event_can_be_played_by_participant', 'image'])->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sports')->withTimestamps();
    }

    public function sagaSports()
    {
        return $this->hasMany(SagaSport::class);
    }

    public function sagaSport()
    {
        return $this->hasOne(SagaSport::class);
    }
}
