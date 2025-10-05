<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldSaga extends Model
{
    protected $connection = 'oldsaga2023';

    protected $table = 'saga_participation_contingents';
}
