<?php

namespace App\Http\Controllers;

use App\SMS;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\User;
use App\Common;
use App\SendMails;
use Auth;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function sendTaskWarningEmail(Request $request){
        try{
            $today = date('Y-m-d');
            $allow_date = date('Y-m-d', strtotime('+7 days'));

            $tasks = UserProjectTask::select('user_project_tasks.*','projects.name as project_name', 'tasks.title', 'tasks.rule',
                'tasks.project_id','users.unique_id','users.username','users.email','users.phone');
            $tasks = $tasks->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id');
            $tasks = $tasks->leftJoin('user_projects', 'user_projects.id', '=', 'user_project_tasks.user_project_id');
            $tasks = $tasks->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id');
            $tasks = $tasks->leftJoin('users', 'users.id', '=', 'user_projects.user_id');
            $tasks = $tasks->where('user_project_tasks.status', 'processing');
            $tasks = $tasks->where('user_project_tasks.warning_sent',0);
            $tasks = $tasks->where(function ($query) use ($today,$allow_date) {
                $query->orWhere('user_project_tasks.original_delivery_date',$allow_date);
                $query->orWhere('user_project_tasks.original_delivery_date','<',$today);
            });
            $tasks = $tasks->get();

            //echo "<pre>"; print_r($tasks); echo "</pre>"; exit();

            foreach($tasks as $task){
                $email = [$task->email];

                if($task->original_delivery_date<$today){ // Due date have been past
                    $result = Common::sendPastDayWarningEmail($email,$task);

                    /*
                     * Send past warning sms
                     * */
                    $result = Common::sendPastDayWarningSms($tasks->phone,$task);

                }
                else{
                    $result = Common::send7dayWarningEmail($email,$task);

                    /*
                     * Send 7 day before warning sms
                     * */
                    $result = Common::send7dayWarningSms($tasks->phone,$task);
                }

                if($task->original_delivery_date<$today && $result=='ok'){
                    $task->warning_sent = 1;
                    $task->save();
                }
            }

            return count($tasks).' Email sent.';

        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'CronController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

}
