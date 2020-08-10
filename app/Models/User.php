<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
=======

class User extends Model
>>>>>>> 876681c647cfc95683ddf2ed9cfe614d4d7d0bc8
{
    protected $table = 'users';

    public $primaryKey = 'id';

    public $timestamps = false;


    public function projects()
    {
        $instance = $this->hasMany('App\Models\UserProject','user_id','id');
        /*$instance = $instance->select('user_project_tasks.*','tasks.title','tasks.has_freeze_rule');
        $instance = $instance->join('user_project_tasks','user_project_tasks.user_project_id','user_projects.id');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->where('tasks.status','active');
        $instance = $instance->where('user_project_tasks.status','processing');
        $instance = $instance->groupBy('user_project_tasks.user_project_id');
        //$instance = $instance->orderBy('user_project_tasks.id','ASC');*/
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
