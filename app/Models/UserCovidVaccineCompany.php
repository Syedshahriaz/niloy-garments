<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCovidVaccineCompany extends Model
{
    protected $table = 'user_covid_vaccine_companies';

    public $primaryKey = 'id';

    public $timestamps = false;
}
