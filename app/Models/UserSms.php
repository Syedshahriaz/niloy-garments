<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSms extends Model
{
    protected $table = 'user_sms';

    public $primaryKey = 'id';

    public $timestamps = false;
}
