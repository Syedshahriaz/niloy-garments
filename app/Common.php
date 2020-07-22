<?php

namespace App;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ErrorLog;
use Carbon\Carbon;
use Session;
use Auth;
use DB;

/**
 * Class Common, this class is to use project common functions
 *
 * @package App
 */
class Common
{
    const SITE_TITLE = 'Niloy Garments';
    const DOMAIN_NAME = 'tna.ownenterprise.com';
    const SITE_URL = 'http://tna.ownenterprise.com';
    const FROM_EMAIL = 'mail2technerd@gmail.com';
    const FROM_NAME = 'Niloy Garments';

    const VALID_IMAGE_EXTENSIONS = ['jpg','JPG','jpeg','JPEG'];
    const VALID_FILE_EXTENSIONS = ['jpg','JPG','jpeg','JPEG','png','PNG','svg','doc','docx','odt','xls','xlsx','ods','pdf'];

    public static function is_admin_login(){
        if (Session::get('user_id') && Session::get('role')==2) {
            return 1;
        }
        return 0;
    }

    public static function getNotifications($user_id=''){
        if($user_id == ''){
            $user = Auth::user();
            $user_id = $user->id;
        }

        $notifications = Notification::where('user_id',$user_id)
            ->orWhere('parent_id',$user_id)
            ->get();
        return $notifications;
    }

    public static function getUnreadNotifications($user_id=''){
        if($user_id == ''){
            $user = Auth::user();
            $user_id = $user->id;
        }
        $notifications = Notification::where('user_id',$user_id)
            ->orWhere('parent_id',$user_id)
            ->where('is_read',0)
            ->get();
        return $notifications;
    }

    public static function task_editable($task,$shipment_date){
        $result = 0;

        /*
         * Check if task freeze rule is dependent with other task or not
         * */
        if($task->freeze_dependent_with ==''){
            /*
             * Check if self task is editable
             * */
            $result = self::isTaskEditable($task,$shipment_date);
        }
        else{
            /*
             * Get the dependent task
             * */
            $dependent_task = Task::where('id',$task->freeze_dependent_with)->first();
            /*
             * Check if dependent task is editable
             * */
            $dependent_editable = self::isTaskEditable($dependent_task,$shipment_date);
            if($dependent_editable==1){
                /*
                 * Check if self task is editable
                 * */
                $result = self::isTaskEditable($task,$shipment_date);
            }

        }

        return $result;
    }

    public static function isTaskEditable($task,$shipment_date){
        $result = 0;
        /*if($task->has_freeze_rule==1 && $task->status != 'completed' && $task->delivery_date_update_count < 2){
            $result = 1;
        }*/
        //else if(($task->status == 'processing' || $task->status == 'completed') && $task->freeze_forever!=1 && $task->delivery_date_update_count < 2){
        if(($task->status == 'processing' || $task->status == 'completed') && $task->freeze_forever!=1 && $task->delivery_date_update_count < 2){
            $result = 1;
        }

        /*
         * Now check if task is in date range
         * */
        if($result==1){
            $result = self::task_in_date_range($shipment_date,$task->days_range_start,$task->days_range_end);
        }

        return $result;
    }

    public static function task_in_date_range($shipment_date,$days_range_start,$days_range_end){
        if($days_range_start == ''){
            return 1;
        }
        $today = date('Y-m-d');
        $nsd_start = date('Y-m-d', strtotime($shipment_date. ' + '.$days_range_start.' days'));
        $nsd_end = date('Y-m-d', strtotime($shipment_date. ' + '.$days_range_end.' days'));

        if($days_range_end == ''){
            if($today>=$nsd_start){
                return 1;
            }
        }
        else{
            if($today>=$nsd_start && $today<=$nsd_end){
                return 1;
            }
        }

        return 0;
    }

    public static function removeUserProject($user_id){
        $user_project_ids = UserProject::select('id')
            ->where('user_id',$user_id)
            ->pluck('id')
            ->toArray();

        /*
         * Removing user tasks
         * */
        UserProjectTask::whereIn('user_project_id',$user_project_ids)->delete();

        /*
         * Removing user project
         * */
        UserProject::where('user_id',$user_id)->delete();

        return 'ok';
    }

    public static function getOfferedProject($gender,$has_offer_1,$has_offer_2){
        $projects = Project::select('projects.*','tasks.title','tasks.days_to_add','user_projects.id as user_project_id');
        $projects = $projects->leftJoin('tasks','tasks.project_id','=','projects.id');
        $projects = $projects->leftJoin('user_projects','user_projects.project_id','=','projects.id');
        $projects = $projects->where('projects.status','active');
        $projects = $projects->where(function ($query) use ($gender,$has_offer_1,$has_offer_2) {
            if($has_offer_1==1){
                $query->orWhere('has_offer_1', 1);
            }
            if($has_offer_2==1){
                $query->orWhere('has_offer_2', 1);
            }

            if($gender == 'Female'){
                $query->orWhere('has_offer_3', 1);
            }
        });
        $projects = $projects->groupBy('projects.id');
        $projects = $projects->get();

        return $projects;
    }

    public static function saveUserProject($projects,$user_id,$shipment,$purchase_date){
        foreach($projects as $key=>$project){
            $userProject = NEW UserProject();
            $userProject->user_id = $user_id;
            $userProject->project_id = $project->id;
            if($project->day_add_with=='shipment_date'){
                $userProject->start_date = date('Y-m-d', strtotime($shipment->shipment_date. ' + '.$project->days_to_add.' days'));
            }
            else if($project->day_add_with=='purchase_date'){
                $userProject->start_date = date('Y-m-d', strtotime($purchase_date. ' + '.$project->days_to_add.' days'));
            }
            else{
                $userProject->has_special_date = 1;
            }
            $userProject->save();

            $tasks = Task::where('project_id',$project->id)->get();

            /*
             * Saving user project tasks
             * */
            $result = self::saveUserTask($project,$tasks,$userProject,$shipment,$purchase_date);
        }
    }

    public static function saveUserTask($project,$tasks,$userProject,$shipment,$purchase_date){
        foreach($tasks as $key=>$task){
            $projectTask = NEW UserProjectTask();
            $projectTask->user_project_id = $userProject->id;
            $projectTask->task_id = $task->id;
            if($task->status =='active'){
                $days_to_add = self::calculateDaysToAdd($task,$shipment->shipment_date);

                if($project->day_add_with=='shipment_date') {
                    $projectTask->due_date = date('Y-m-d',
                        strtotime($shipment->shipment_date . ' + ' . $days_to_add. ' days'));
                    $projectTask->original_delivery_date = date('Y-m-d',
                        strtotime($shipment->shipment_date . ' + ' . $days_to_add . ' days'));
                }
                else if($project->day_add_with=='purchase_date'){
                    $projectTask->due_date = date('Y-m-d',
                        strtotime($purchase_date . ' + ' . $days_to_add . ' days'));
                    $projectTask->original_delivery_date = date('Y-m-d',
                        strtotime($purchase_date . ' + ' . $days_to_add . ' days'));
                }
                else{
                    // keep due_date and original_delivery_date NULL
                }
            }
            if($key==0){
                $projectTask->status = 'processing';
            }
            else{
                $projectTask->status = 'not initiate';
            }
            $projectTask->freeze_forever = $task->freeze_forever;
            $projectTask->save();
        }
    }

    public static function calculateDaysToAdd($task,$shipment_date){
        if($task->alternet_days_to_add==''){
            $days_to_add = $task->days_to_add;
        }
        else{
            /*
             * Check if dependent task freeze or active
             * */
            $dependentTask = Task::where('id',$task->dependent_task_to_add_days)->first();
            $in_date_range = self::task_in_date_range($shipment_date,$dependentTask->days_range_start,$dependentTask->days_range_end);
            if($in_date_range==0){ // The dependent task is freezed
                $days_to_add = $task->alternet_days_to_add;
            }
            else{ // Dependent task is active
                $days_to_add = $task->days_to_add;
            }
        }

        return $days_to_add;
    }

    public static function send7dayWarningEmail($email,$task){
        /*
         * Send task 7 day before complete warning email
         */
        $today = date('Y-m-d');

        $email_to = $email;
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

        $view = 'emails.project_task_complete_7day_warning_email';

        $result = SendMails::sendMail($emailData, $view);
        return $result;
    }

    public static function sendPastDayWarningEmail($email,$task){
        /*
         * Send task past day complete warning email
         */
        $today = date('Y-m-d');

        $email_to = $email;
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

        $view = 'emails.project_task_complete_past_warning_email';

        $result = SendMails::sendMail($emailData, $view);
        return $result;
    }

    public static function saveErrorLog($method,$line_number,$file_path,$message,$object,$type,$screenshot,$page_url,$argument,$prefix,$domain){

        /*Save error to database*/
        try{
            $errorLog = NEW ErrorLog();
            $errorLog->method_name = $method;
            $errorLog->line_number = $line_number;
            $errorLog->file_path = $file_path;
            $errorLog->exception_message = $message;
            $errorLog->object = $object;
            $errorLog->type = $type;
            $errorLog->screenshot = $screenshot;
            $errorLog->page_url = $page_url;
            $errorLog->arguments = $argument;
            $errorLog->prefix = $prefix;
            $errorLog->domain = $domain;
            $errorLog->save();
            return $errorLog->error_log_id;
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /*
    | Get two Date difference in days
    */
    public static function getDateDiffDays($date1, $date2)
    {
        try{
            $timeDiff = strtotime($date1) - strtotime($date2);
            $daysDiff = $timeDiff/86400;  // 86400 seconds in one day
            return $daysDiff;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    /*
    | Get Month From Date
    */
    public static function getMonth($time)
    {
        try{
            $date = new Carbon( $time );
            return $date->month;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    /*
    | Get Year From Date
    */
    public static function getYear($time)
    {
        try{
            $date = new Carbon( $time );
            return $date->year;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public static function generaterandomNumber($length){
        $min = pow(10,$length);
        $max = pow(10,$length+1);
        $value = rand($min, $max);
        return $value;
    }

    public static function generaterandomString($length){
        $string = substr(md5(uniqid(mt_rand(), true)), 0, $length);
        return $string;
    }

    public static function generateUniqueNumber($number){
        $number_length = strlen($number);
        $leading_zero = 9-$number_length;
        for($i=$leading_zero; $i>0; $i--){
            $number = '0'.$number;
        }

        $insertion = "-";
        $index1 = 6;
        $index2 = 3;
        $number = substr_replace($number, $insertion, $index1, 0);
        $number = substr_replace($number, $insertion, $index2, 0);

        return $number;
    }

    public static function isValidImageExtension($image_file){
        $extension = $image_file->getClientOriginalExtension();
        if(in_array($extension, Common::VALID_IMAGE_EXTENSIONS)){
            return 1;
        }
        else{
            return 0;
        }
    }

}//End
