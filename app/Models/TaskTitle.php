<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTitle extends Model
{
    protected $table = 'task_title';

    public $primaryKey = 'id';

    public $timestamps = false;
}
