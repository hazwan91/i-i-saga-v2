<?php

namespace App\Models;

use App\Enums\RegistrationCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class SagaRegistrationCommiteeRole extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationCommiteeRoleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_registration_commitee_id',
        'saga_commitee_role_id',
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
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected static ?string $dateStart = 'date_start_rcom';

    protected static ?string $dateEnd = 'date_end_rcom';

    protected static function sagaSelected()
    {
        return session()->get('event');
    }

    protected static function dateRegistrationIsFilled($saga)
    {
        return in_array(static::$dateStart, $saga) && in_array(static::$dateEnd, $saga) && $saga[static::$dateStart] && $saga[static::$dateEnd];
    }

    public static function isRegistrationOpen(): ?string
    {
        $saga = static::sagaSelected();
        if (static::dateRegistrationIsFilled($saga)) {
            return false;
        }

        $now = Carbon::now()->format('Y-m-d');
        $start = $saga[static::$dateStart];
        $end = $saga[static::$dateEnd];
        if ($now >= $start && $now <= $end) {
            return true;
        } else {
            return false;
        }
    }

    public static function registrationStatusColor()
    {
        if (self::isRegistrationOpen()) {
            return 'success';
        } else {
            return 'danger';
        }
    }

    public static function registrationStatusLabel()
    {
        if (self::isRegistrationOpen()) {
            return 'B';
        } else {
            return 'T';
        }
    }

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
