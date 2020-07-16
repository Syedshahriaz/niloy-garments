<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $table = 'user_projects';

    public $primaryKey = 'id';

    public $timestamps = false;

    public function tasks()
    {
        $instance = $this->hasMany('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->join('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('tasks.status','active');
        return $instance;
    }

    public function running_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'task_title.name as title','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->join('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('tasks.status','active');
        //$instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->orderBy('user_project_tasks.id','ASC');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function last_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'task_title.name as title','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->join('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('tasks.status','active');
        //$instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->orderBy('user_project_tasks.id','DESC');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function passed_task()
    {
        $today = date('Y-m-d');
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','id');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->where('original_delivery_date','<',$today);
        $instance = $instance->where('tasks.status','active');
        $instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function recent_due_task()
    {
        $today = date('Y-m-d');
        $lastDay = date('Y-m-d', strtotime('+6 days'));

        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','id');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->whereBetween('original_delivery_date',[$today,$lastDay]);
        $instance = $instance->where('tasks.status','active');
        $instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->limit(1);
        return $instance;
    }
}
