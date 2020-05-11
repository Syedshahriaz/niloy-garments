<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserShipment extends Model
{
    protected $table = 'user_shipments';

    public $primaryKey = 'id';

    public $timestamps = false;
}
