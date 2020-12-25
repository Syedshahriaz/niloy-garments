<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CovidVaccineDose extends Model
{
    protected $table = 'covid_vaccine_doses';

    public $primaryKey = 'id';

    public $timestamps = false;
}
