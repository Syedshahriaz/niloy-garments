<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $table = 'user_projects';

    public $primaryKey = 'id';

    public $timestamps = false;

    public function running_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','id');
        $instance = $instance->select('user_project_tasks.*','tasks.title');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->orderBy('user_project_tasks.id','ASC');
        //$instance = $instance->limit(1);
        return $instance;
    }
}
