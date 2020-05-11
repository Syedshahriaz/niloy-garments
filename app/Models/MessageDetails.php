<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageDetails extends Model
{
    protected $table = 'message_details';

    public $primaryKey = 'id';

    public $timestamps = false;
}
