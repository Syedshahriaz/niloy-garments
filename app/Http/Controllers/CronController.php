<?php

namespace App\Http\Controllers;

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
        //try{
            $today = date('Y-m-d');
            $allow_date = date('Y-m-d', strtotime('+7 days'));

            $tasks = UserProjectTask::select('user_project_tasks.*','projects.name as project_name', 'tasks.title', 'tasks.rule',
                'tasks.project_id','users.unique_id','users.username','users.email');
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
                /*
                 * Send otp confirmation email
                 */
                $email_to = [$task->email];
                $email_cc = [];
                $email_bcc = [];

                $emailData['from_email'] = Common::FROM_EMAIL;
                $emailData['from_name'] = Common::FROM_NAME;
                $emailData['email'] = $email_to;
                $emailData['email_cc'] = $email_cc;
                $emailData['email_bcc'] = $email_bcc;
                $emailData['task'] = $task;
                $emailData['subject'] = 'Niloy Garments- Project task completion warning';

                $emailData['bodyMessage'] = '';

                if($task->original_delivery_date<$today){ // Due date have been past
                    $view = 'emails.project_task_complete_past_warning_email';
                }
                else{
                    $view = 'emails.project_task_complete_7day_warning_email';
                }

                $result = SendMails::sendMail($emailData, $view);

                if($task->original_delivery_date<$today && $result=='ok'){
                    $task->warning_sent = 1;
                    $task->save();
                }
            }

            return count($tasks).' Email sent.';

        /*}
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'CronController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }
}
