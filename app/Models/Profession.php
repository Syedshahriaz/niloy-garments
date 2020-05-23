<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $table = 'professions';

    public $primaryKey = 'id';

    public $timestamps = false;
}
