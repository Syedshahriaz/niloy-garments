<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public $primaryKey = 'id';

    public $timestamps = false;

    public function tasks()
    {
        $instance = $this->hasMany('App\Models\Task','project_id','id');
        $instance = $instance->where('tasks.status','!=','active');
        return $instance;
    }
}
