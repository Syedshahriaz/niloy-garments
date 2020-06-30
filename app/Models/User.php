<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public $primaryKey = 'id';

    public $timestamps = false;


    public function running_task()
    {
        $instance = $this->hasOne('App\Models\UserProject','user_id','id');
        $instance = $instance->select('user_project_tasks.*','tasks.title','tasks.has_freeze_rule');
        $instance = $instance->join('user_project_tasks','user_project_tasks.user_project_id','user_projects.id');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->where('tasks.status','active');
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->orderBy('user_project_tasks.id','ASC');
        return $instance;
    }

    public function last_task()
    {
        $instance = $this->hasOne('App\Models\UserProject','user_id','id');
        $instance = $instance->select('user_project_tasks.*','tasks.title','tasks.has_freeze_rule');
        $instance = $instance->join('user_project_tasks','user_project_tasks.user_project_id','user_projects.id');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->where('tasks.status','active');
        $instance = $instance->orderBy('user_project_tasks.id','DESC');
        return $instance;
    }

}
