<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProjectTask extends Model
{
    protected $table = 'user_project_tasks';

    public $primaryKey = 'id';

    public $timestamps = false;
}
