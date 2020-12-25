<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CovidVaccineCompany extends Model
{
    protected $table = 'covid_vaccine_companies';

    public $primaryKey = 'id';

    public $timestamps = false;
}
