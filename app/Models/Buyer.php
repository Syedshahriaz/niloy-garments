<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyers';

    public $primaryKey = 'id';

    public $timestamps = false;
}
