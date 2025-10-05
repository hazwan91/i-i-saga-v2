<?php

namespace App\Models;

use App\Enums\CheckingType;
use App\Enums\Sex;
use App\Enums\ShoeSize;
use App\Enums\TracksuitSize;
use App\Enums\TshirtSize;
use App\Enums\Warganegara;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class SagaRegistrationTechnical extends Model
{
    /** @use HasFactory<\Database\Factories\SagaRegistrationTechnicalFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'saga_id',
        'race_id',
        'current_district_id',
        'place_of_birth_id',
        'ic',
        'passport',
        'name',
        'acreditation_name',
        'dob',
        'age',
        'height',
        'weight',
        'is_malaysia',
        'address',
        'employer_address',
        'house_tel_no',
        'hp_no',
        'sex',
        't_shirt_size',
        'tracksuit_size',
        'shoe_size',
        'image',
        'id_image',
        'id_pdf',
        'certificate_image',
        'certificate_pdf',
        'other_image',
        'other_pdf',
        'is_blocked',
        'blocked_remark',
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
        'saga_id' => 'integer',
        'race_id' => 'integer',
        'current_district_id' => 'integer',
        'place_of_birth_id' => 'integer',
        'ic' => 'string',
        'passport' => 'string',
        'name' => 'string',
        'acreditation_name' => 'string',
        'dob' => 'date',
        'age' => 'integer',
        'height' => 'string',
        'weight' => 'string',
        'is_malaysia' => Warganegara::class,
        'address' => 'string',
        'employer_address' => 'string',
        'house_tel_no' => 'string',
        'hp_no' => 'string',
        'sex' => Sex::class,
        't_shirt_size' => TshirtSize::class,
        'tracksuit_size' => TracksuitSize::class,
        'shoe_size' => ShoeSize::class,
        'image' => 'string',
        'id_image' => 'array',
        'id_pdf' => 'array',
        'certificate_image' => 'array',
        'certificate_pdf' => 'array',
        'other_image' => 'array',
        'other_pdf' => 'array',
        'is_blocked' => 'boolean',
        'blocked_remark' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected static function booted()
    {
        static::addGlobalScope('currentSaga', function (Builder $builder) {
            $builder->whereRelation('saga', 'id', '=', session()->get('event')['id']);
        });
    }

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function sagaSport()
    {
        return $this->belongsTo(SagaSport::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function currentDistrict()
    {
        return $this->belongsTo(District::class, 'current_district_id');
    }

    public function placeOfBirthDistrict()
    {
        return $this->belongsTo(District::class, 'place_of_birth_id');
    }

    public function sagaRegistrationTechnicalRoles()
    {
        return $this->hasMany(SagaRegistrationTechnicalRole::class);
    }

    public function saga()
    {
        return $this->belongsTo(Saga::class);
    }

    public function sagaRegistrationTechnicalRecords()
    {
        return $this->hasMany(SagaRegistrationTechnicalRecord::class);
    }

    public function sagaRegistrationTechnicalStatuses()
    {
        return $this->hasMany(SagaRegistrationTechnicalStatus::class)->where('type', CheckingType::INDIVIDU);
    }

    public function sagaRegistrationTechnicalStatusLatest()
    {
        return $this->hasOne(SagaRegistrationTechnicalStatus::class)->where('type', CheckingType::INDIVIDU)->orderByDesc('id')->orderByDesc('created_at');
    }
}
