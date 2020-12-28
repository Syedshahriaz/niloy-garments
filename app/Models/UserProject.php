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

    public function free_tasks()
    {
        $instance = $this->hasMany('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'covid_vaccine_doses.dose_name as title', 'tasks.rule', 'covid_vaccine_doses.status as task_status', 'tasks.project_id','covid_vaccine_doses.days_to_add','covid_vaccine_doses.days_range_start','covid_vaccine_doses.days_range_end','covid_vaccine_doses.update_date_with','covid_vaccine_doses.has_freeze_rule','covid_vaccine_doses.freeze_dependent_with','covid_vaccine_doses.skip_background_rule');
        $instance = $instance->leftJoin('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id');
        $instance = $instance->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('covid_vaccine_doses.status','active');
        return $instance;
    }

    public function running_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->join('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('tasks.status','active');
        //$instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->orderBy('user_project_tasks.id','ASC');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function free_running_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'covid_vaccine_doses.dose_name as title', 'tasks.rule', 'covid_vaccine_doses.status as task_status', 'tasks.project_id','covid_vaccine_doses.days_to_add','covid_vaccine_doses.days_range_start','covid_vaccine_doses.days_range_end','covid_vaccine_doses.update_date_with','covid_vaccine_doses.has_freeze_rule','covid_vaccine_doses.freeze_dependent_with','covid_vaccine_doses.skip_background_rule','covid_vaccine_companies.name as company_name');
        $instance = $instance->leftJoin('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id');
        $instance = $instance->leftJoin('covid_vaccine_companies', 'covid_vaccine_companies.id', '=', 'covid_vaccine_doses.company_id');
        $instance = $instance->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('covid_vaccine_doses.status','active');
        //$instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->where('user_project_tasks.status','processing');
        //$instance = $instance->orderBy('user_project_tasks.id','ASC');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function last_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->join('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('tasks.status','active');
        //$instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->orderBy('user_project_tasks.id','DESC');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function free_last_task()
    {
        $instance = $this->hasOne('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'covid_vaccine_doses.dose_name as title', 'tasks.rule', 'covid_vaccine_doses.status as task_status', 'tasks.project_id','covid_vaccine_doses.days_to_add','covid_vaccine_doses.days_range_start','covid_vaccine_doses.days_range_end','covid_vaccine_doses.update_date_with','covid_vaccine_doses.has_freeze_rule','covid_vaccine_doses.freeze_dependent_with','covid_vaccine_doses.skip_background_rule','covid_vaccine_companies.name as company_name');
        $instance = $instance->leftJoin('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id');
        $instance = $instance->leftJoin('covid_vaccine_companies', 'covid_vaccine_companies.id', '=', 'covid_vaccine_doses.company_id');
        $instance = $instance->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('covid_vaccine_doses.status','active');
        //$instance = $instance->where('tasks.has_freeze_rule',0);
        $instance = $instance->orderBy('user_project_tasks.id','DESC');
        //$instance = $instance->limit(1);
        return $instance;
    }

    public function completed_tasks()
    {
        $instance = $this->hasMany('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule');
        $instance = $instance->join('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->join('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('tasks.status','active');
        $instance = $instance->where('user_project_tasks.status','completed');
        return $instance;
    }

    public function free_completed_tasks()
    {
        $instance = $this->hasMany('App\Models\UserProjectTask','user_project_id','user_project_id');
        $instance = $instance->select('user_project_tasks.*', 'covid_vaccine_doses.dose_name as title', 'tasks.rule', 'covid_vaccine_doses.status as task_status', 'tasks.project_id','covid_vaccine_doses.days_to_add','covid_vaccine_doses.days_range_start','covid_vaccine_doses.days_range_end','covid_vaccine_doses.update_date_with','covid_vaccine_doses.has_freeze_rule','covid_vaccine_doses.freeze_dependent_with','covid_vaccine_doses.skip_background_rule','covid_vaccine_companies.name as company_name');
        $instance = $instance->leftJoin('tasks','tasks.id','user_project_tasks.task_id');
        $instance = $instance->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id');
        $instance = $instance->leftJoin('covid_vaccine_companies', 'covid_vaccine_companies.id', '=', 'covid_vaccine_doses.company_id');
        $instance = $instance->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
        $instance = $instance->where('covid_vaccine_doses.status','active');
        $instance = $instance->where('user_project_tasks.status','completed');
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
