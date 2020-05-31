<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeparateUserLog extends Model
{
    protected $table = 'separate_user_logs';

    public $primaryKey = 'id';

    public $timestamps = false;
}
