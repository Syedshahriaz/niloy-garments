<?php

namespace App;
use App\Models\MessageDetails;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\Notification;
use App\Models\UserShipment;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserSms;
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
    const SITE_TITLE = 'Vujadetec';
    const DOMAIN_NAME = 'vujadetec.net';
    const SITE_URL = 'https://vujadetec.net';
    //const SITE_URL = 'http://127.0.0.1:8000';
    const FROM_EMAIL = 'vujadetec@gmail.com';
    const FROM_NAME = 'Vujadetec';

    /* You can set EASYPAY_MODE to sandbox or live*/
    const EASYPAY_MODE = 'live';
    const EASYPAY_SANDBOX_URL = 'https://sandbox.easypayway.com/payment/request.php';
    const EASYPAY_SANDBOX_STORE_ID = 'epw';
    const EASYPAY_SANDBOX_SIGNATURE_KEY = 'dc0c2802bf04d2ab3336ec21491146a3';
    const EASYPAY_LIVE_URL = 'https://securepay.easypayway.com/payment/request.php';
    const EASYPAY_LIVE_STORE_ID = 'vujadetec';
    const EASYPAY_LIVE_SIGNATURE_KEY = '8c6404963b81604381d5070e92fc4fcb';
    const PAYMENT_SUCCESS_URL = Common::SITE_URL.'/payment_success';
    const PAYMENT_FAILED_URL = Common::SITE_URL.'/payment_fail';
    const PAYMENT_CANCEL_URL = Common::SITE_URL.'/payment_cancel';


    const VALID_IMAGE_EXTENSIONS = ['jpg','JPG','jpeg','JPEG','png','PNG'];
    const VALID_FILE_EXTENSIONS = ['jpg','JPG','jpeg','JPEG','png','PNG','svg','doc','docx','odt','xls','xlsx','ods','pdf'];

    public static function is_admin_login(){
        if (Session::get('user_id') && Session::get('role')==2) {
            return 1;
        }
        return 0;
    }

    public static function is_user_login(){
        if (Session::get('user_id') && Session::get('role')==3) {
            return 1;
        }
        return 0;
    }

    public static function checkPaymentAndShipentStatus(){
        $user = Auth::user();
        /*
         * Check if payment done for this user
         * */
        $payment = Payment::where('user_id', $user->id)->first();
        if (empty($payment)) {
            return 'empty_payment';
        }
        if ($payment->payment_status != 'Completed') {
            return 'empty_payment';
        }

        /*
         * Check if shipment date selected already
         * */
        $shipment = UserShipment::where('user_id', $user->id)->first();

        if (empty($shipment)) {
            return 'empty_shipment';
        }

        return 'active_user';
    }

    public static function saveNotification($user,$message){
        $notification = NEW Notification();
        $notification->user_id = $user->user_id;
        if($user->parent_id==0){
            $notification->parent_id = $user->user_id;
        }
        else{
            $notification->parent_id = $user->parent_id;
        }
        $notification->message = $message;
        $notification->save();

        return 1;
    }

    public static function getNotifications($user_id=''){
        if($user_id == ''){
            $user = Auth::user();
            $user_id = $user->id;
        }

        $notifications = Notification::where('parent_id',$user_id)
            //->orWhere('parent_id',$user_id)
                ->orderBy('id','DESC')
            ->get();
        return $notifications;
    }

    public static function getNotificationDetails($notification_id=''){

        $notifications = Notification::where('id',$notification_id)
            ->orderBy('id','DESC')
            ->get();
        return $notifications;
    }

    public static function getUnreadNotifications($user_id=''){
        if($user_id == ''){
            $user = Auth::user();
            $user_id = $user->id;
        }
        $notifications = Notification::where('parent_id',$user_id)
            //->orWhere('parent_id',$user_id)
            ->where('is_read',0)
            ->orderBy('id','DESC')
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
            //$dependent_task = Task::where('id',$task->freeze_dependent_with)->first();
            $dependent_task = UserProjectTask::select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule')
                ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                ->join('task_title', 'task_title.id', '=', 'tasks.title_id')
                ->where('user_project_id', $task->user_project_id)
                ->where('tasks.id',$task->freeze_dependent_with)
                ->where('tasks.status', 'active')
                ->first();
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
        $result = self::isEditableStatusCheck($task,$shipment_date);

        /*
         * Now check if task is in date range
         * */
        if($result==1){
            $result = self::task_in_date_range($shipment_date,$task->days_range_start,$task->days_range_end);
        }

        return $result;
    }

    public static function isEditableStatusCheck($task,$shipment_date){
        $result = 0;
        $is_passed = 0;

        if(($task->status == 'processing' || $task->status == 'completed') && $task->freeze_forever!=1){
            $result = 1;
        }
        else if(isset($task->has_offer_1) && $task->has_offer_1==1){ // If task is for green offer(offer 1) and due date have been passed then make editable
            $result = self::isTaskOriginalDueDatePassed($task);
            if($result==1){
                $is_passed = 1;
            }
        }
        else if($task->has_freeze_rule==1 && $task->freeze_forever!=1){ // If task has freeze rule then pass to next step to allow to make editable
            $result = 1;
        }

        /*
         * Check if previous any task has 'processing' status and editable. If yes then make this task non editable
         * */
        if($result ==1 && $is_passed==0){
            $processing_result = self::isPreviousAnyTaskProcessing($task,$shipment_date);
            if($processing_result==1){ // Previous processing/editable task exists
                $result = 0;           // So make this task non editable.
            }
        }

        return $result;
    }

    public static function isPreviousAnyTaskProcessing($task,$shipment_date){
        /*
         * Get details of previous processing task (if any).
         * */
        $previous_task = UserProjectTask::select('user_project_tasks.*','tasks.days_range_start','tasks.days_range_end')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_tasks.id','<',$task->id)
            ->where('user_project_tasks.user_project_id',$task->user_project_id)
            ->where('user_project_tasks.status','processing')
            ->first();

        if(!empty($previous_task)){ // If previous processing task found
            /*
             * Now check if previous task is in editable date range.
             * If not in date range then previous task is not editable.
             * */
            $result = self::task_in_date_range($shipment_date,$previous_task->days_range_start,$previous_task->days_range_end);
            return $result;
        }
        return 0;
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

    public static function isTaskOriginalDueDatePassed($task){
        $today = date('Y-m-d');
        if($task->original_delivery_date < $today){
            return 1;
        }
        else{
            return 0;
        }
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

            $tasks = Task::select('tasks.*','tasks.id as task_id')
                ->where('project_id',$project->id)
                ->get();

            /*
             * Saving user project tasks
             * */
            $result = self::saveUserTask($project,$tasks,$userProject,$shipment,$purchase_date);
        }
    }

    public static function saveUserTask($project,$tasks,$userProject,$shipment,$purchase_date,$user_id=''){
        foreach($tasks as $key=>$task){
            $projectTask = NEW UserProjectTask();
            $projectTask->user_project_id = $userProject->id;
            $projectTask->task_id = $task->id;
            if($task->status =='active'){
                $days_to_add = self::calculateDaysToAdd($task,$shipment->shipment_date);

                $years_diff = (time()-strtotime($shipment->shipment_date))/(3600*24*365.25);

                if($task->under_age_rule !='' && $years_diff<$task->under_age_rule){ // If task has under_age_rule and age is less than under_age_rule years
                    $projectTask->due_date = date('Y-m-d',
                        strtotime($shipment->shipment_date . ' + ' . $days_to_add. ' days'));
                    $projectTask->original_delivery_date = date('Y-m-d',
                        strtotime($shipment->shipment_date . ' + ' . $days_to_add . ' days'));
                }
                else if($project->day_add_with=='shipment_date') {
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

    /*
     * This method will check if task is editable and then make it's status processing
     * */
    public static function checkAndPrepareForTaskProcessing($user_id,$shipment_date){
        $user_projects = UserProject::where('user_id',$user_id)
            ->select('user_projects.*')
            ->join('projects','projects.id','=','user_projects.project_id')
            ->get();

        foreach($user_projects as $key=>$u_project){
            $project_tasks = UserProjectTask::where('user_project_id',$u_project->id)
                ->select('user_project_tasks.*','tasks.days_to_add','tasks.update_date_with')
                ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                ->whereIn('user_project_tasks.status',['not initiate','processing'])
                ->where('tasks.update_date_with', '!=','self_task')
                ->get();

            /*
             * Add user project tasks due date
             * */
            foreach($project_tasks as $key=>$p_task){
                $user_project_task_id = self::makeCorrectTaskEditable($p_task,$shipment_date);
                /*
                 * If one editable task found
                 * then make the previous non editable task status 'not initiate'
                 * */
                if($user_project_task_id!=0){ // If editable task found
                    DB::table('user_project_tasks')
                        ->where('id', '<' ,$user_project_task_id)
                        ->where('user_project_id', $u_project->id)
                        ->update(['status' => 'not initiate']);

                    break 1; // Break this foreach loop
                }
            }

        }
    }

    public static function updateUserProjectTaskDueDate($user_projects,$shipment_date){
        foreach($user_projects as $key=>$u_project){
            $project_tasks = UserProjectTask::where('user_project_id',$u_project->id)
                ->select('user_project_tasks.*','tasks.days_to_add','tasks.update_date_with','projects.has_offer_1','projects.has_offer_2')
                ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                ->join('projects','projects.id','=','tasks.project_id')
                ->whereIn('user_project_tasks.status',['not initiate','processing'])
                //->where('tasks.update_date_with','shipment_date')
                ->get();

            $user = User::where('users.id',$u_project->user_id)
                ->select('users.*','user_payments.created_at as purchase_date')
                ->join('user_payments','user_payments.user_id','=','users.id')
                ->first();

            /*
             * Add user project tasks due date
             * */
            if($u_project->project_id==34){
                foreach($project_tasks as $key=>$p_task){
                    $task = Task::select('tasks.*','tasks.id as task_id')
                        ->where('id',$p_task->task_id)
                        ->first();

                    $years_diff = (time()-strtotime($shipment_date))/(3600*24*365.25);
                    $days_to_add = self::calculateDaysToAdd($task,$shipment_date);

                    if($task->under_age_rule !='' && $years_diff<$task->under_age_rule){ // If task has under_age_rule and age is less than under_age_rule years
                        $parent_date = $shipment_date;
                    }
                    else{
                        $parent_date = $user->purchase_date;
                    }
                    $p_task->due_date = date('Y-m-d',
                        strtotime($parent_date . ' + ' . abs($days_to_add) . ' days'));
                    $p_task->original_delivery_date = date('Y-m-d',
                        strtotime($parent_date . ' + ' . abs($days_to_add) . ' days'));
                    $p_task->save();

                    /*
                     * Making correct task editable
                     * */
                    $result = self::makeCorrectTaskEditable($p_task,$shipment_date);
                }
            }
            else if($u_project->day_add_with=='shipment_date'){
                foreach($project_tasks as $key=>$p_task){
                    $task = Task::select('tasks.*','tasks.id as task_id')
                        ->where('id',$p_task->task_id)
                        ->first();

                    $days_to_add = self::calculateDaysToAdd($task,$shipment_date);

                    $p_task->due_date = date('Y-m-d',
                        strtotime($shipment_date . ' + ' . abs($days_to_add) . ' days'));
                    $p_task->original_delivery_date = date('Y-m-d',
                        strtotime($shipment_date . ' + ' . abs($days_to_add) . ' days'));
                    $p_task->save();

                    /*
                     * Making correct task editable
                     * */
                    $result = self::makeCorrectTaskEditable($p_task,$shipment_date);
                }
            }
            else{
                foreach($project_tasks as $key=>$p_task){
                    $result = self::makeCorrectTaskEditable($p_task,$shipment_date);
                    if($result==1){
                        break 1; // Break this foreach loop
                    }
                }
            }
        }
    }

    public static function calculateDaysToAdd($task,$shipment_date){
        $years_diff = (time()-strtotime($shipment_date))/(3600*24*365.25);

        if($task->under_age_rule !='' && $years_diff<$task->under_age_rule){ // If task has under_age_rule and age is less than under_age_rule years
            $days_to_add = $task->under_age_days_to_add;
        }
        else if($task->project_id==34 && $years_diff>=15){ // If project id=34 and age is greater than 15 years
            $days_to_add = $task->days_to_add;
        }
        else if($task->alternet_days_to_add==''){
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

    public static function makeCorrectTaskEditable($task,$shipment_date){
        return 1;
        /*$project_task = UserProjectTask::where('id',$task->id)->first();
        $taskData = Task::where('id',$task->task_id)->first();

        $in_date_range = Common::task_in_date_range($shipment_date,$taskData->days_range_start,$taskData->days_range_end);
        if($task->has_offer_2==1 && $in_date_range==1){ // The dependent task not freezed and task is for red offer
            $project_task->status = 'processing';
            $project_task->save();

            return $project_task->id;
        }
        return 0;*/
    }

    public static function sendTaskWarningEmail($user_id='',$user_project_id=''){
        $today = date('Y-m-d');
        $next_day = date('Y-m-d');
        $allow_date = date('Y-m-d', strtotime('+6 days'));

        $users = User::select('users.*','user_shipments.shipment_date');
        $users = $users->join('user_shipments', 'user_shipments.user_id', '=', 'users.id');
        $users = $users->where('status','active');
        if($user_id !=''){
            $users = $users->where('users.id', $user_id);
        }
        $users = $users->get();

        foreach($users as $user){
            $message_initiate = 'Dear '.$user->username;
            $tasks = UserProjectTask::select('user_project_tasks.*','projects.name as project_name', 'tasks.title','task_title.name as task_name', 'tasks.rule',
                'tasks.project_id','tasks.days_range_start','tasks.days_range_end','users.unique_id','users.username','users.email','users.phone');
            $tasks = $tasks->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id');
            $tasks = $tasks->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
            $tasks = $tasks->leftJoin('user_projects', 'user_projects.id', '=', 'user_project_tasks.user_project_id');
            $tasks = $tasks->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id');
            $tasks = $tasks->leftJoin('users', 'users.id', '=', 'user_projects.user_id');
            $tasks = $tasks->where('projects.type', 'running');
            $tasks = $tasks->where('users.id', $user->id);
            if($user_project_id !=''){
                $tasks = $tasks->where('user_project_tasks.user_project_id', $user_project_id);
            }
            $tasks = $tasks->whereIn('user_project_tasks.status', ['processing','not initiate']);
            if($user_project_id==''){
                $tasks = $tasks->where('user_project_tasks.warning_sent',0);
            }
            $tasks = $tasks->where(function ($query) use ($today,$next_day,$allow_date) {
                $query->orWhereBetween('user_project_tasks.original_delivery_date',[$next_day,$allow_date]);
                $query->orWhere('user_project_tasks.original_delivery_date','<',$today);
            });
            $tasks = $tasks->orderBy('user_project_tasks.id','ASC');
            $tasks = $tasks->get();

            $past_message_body = '';
            $past_email_body = '';
            $warning_message_body = '';
            $warning_email_body = '';

            foreach($tasks as $task){
                //$task_in_date_range = self::task_in_date_range($user->shipment_date,$task->days_range_start,$task->days_range_end);
                $is_task_editable = self::isTaskEditable($task,$user->shipment_date);
                if($is_task_editable==1){
                    $email = [$task->email];

                    if($task->original_delivery_date<$today){ // Due date have been past
                        $past_message_body .=' Your '.$task->project_name.' '.$task->task_name.' due date is on '.date('d F, Y',strtotime($task->original_delivery_date)).'. ';
                        $past_email_body .='Your '.$task->project_name.' '.$task->task_name.' due date is on '.date('d F, Y',strtotime($task->original_delivery_date)).'. <br>';

                    }
                    else{
                        $warning_message_body .= 'Your '.$task->project_name.' '.$task->task_name.' due date is on '.date('d F, Y',strtotime($task->original_delivery_date)).'. ';
                        $warning_email_body .= 'Your '.$task->project_name.' '.$task->task_name.' due date is on '.date('d F, Y',strtotime($task->original_delivery_date)).'. <br>';
                    }

                    /*
                     * Update task warning email sent status
                     * */
                    $task->warning_sent = 1;
                    $task->save();
                }
            }

            if($past_message_body !=''){
                $past_message_body = $message_initiate.', '.$past_message_body.'Please visit www.vujadetec.com to get more information about our product & services.';
                $past_email_body = $message_initiate.', <br>'.$past_email_body.' <br>Please visit <a href="www.vujadetec.com">www.vujadetec.com</a> to get more information about our product & services.';
                $sms_response = self::sendPastDayWarningSms($user->phone,$past_message_body);
                $email_response = self::sendPastDayWarningEmail($email,$past_email_body);
                $result = self::storeSmsRecord($user->id, $past_message_body);
            }
            if($warning_message_body !=''){
                $warning_message_body = $message_initiate.', '.$warning_message_body.'Please visit www.vujadetec.com to get more information about our product & services.';
                $warning_email_body = $message_initiate.', <br>'.$warning_email_body.' <br>Please visit <a href="www.vujadetec.com">www.vujadetec.com</a> to get more information about our product & services.';
                $sms_response = self::sendPastDayWarningSms($user->phone,$warning_message_body);
                $email_response = self::send7dayWarningEmail($email,$warning_email_body);
                $result = self::storeSmsRecord($user->id, $warning_message_body);
            }

        }

        return 'Email sent.';
    }

    public static function send7dayWarningEmail($email,$message_body){
        /*
         * Send task 7 day before complete warning email
         */

        $email_to = $email;
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['subject'] = Common::SITE_TITLE.'- Vaccine completion warning';

        $emailData['bodyMessage'] = $message_body;

        $view = 'emails.project_task_complete_7day_warning_email';

        $result = SendMails::sendMail($emailData, $view);
        return $result;
    }

    public static function sendPastDayWarningEmail($email,$message_body){
        /*
         * Send task past day complete warning email
         */

        $email_to = $email;
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['subject'] = Common::SITE_TITLE.'- Vaccine completion warning';

        $emailData['bodyMessage'] = $message_body;

        $view = 'emails.project_task_complete_past_warning_email';

        $result = SendMails::sendMail($emailData, $view);
        return $result;
    }

    /*
     * Counting task due date left days
     * */
    public static function dueDayLeftCount($task){
        $now = time(); // or your date as well
        $original_delivery_date = strtotime($task->original_delivery_date);
        $datediff = $now - $original_delivery_date;

        $day_left = round($datediff / (60 * 60 * 24));

        return $day_left;
    }

    public static function removeUserDuplicateShippingRecord($user_id){
        $userShipmentId = UserShipment::select('id')
            ->where('user_id',$user_id)
            ->get();
        if(count($userShipmentId)>1){
            UserShipment::where('user_id',$user_id)
                ->whereNull('shipment_date')
                ->delete();
        }
        return 1;
    }

    public static function removeAllDuplicateShippingRecord(){
        $userShipmentId = UserShipment::select('id')
            ->groupBy('user_id')
            ->pluck('id')
            ->toArray();
        UserShipment::whereNotIn('id', $userShipmentId )->delete();

        return 1;
    }

    /*
     * SMS sending methods
     * */

    public static function sendRegistrationConfirmationSms($username,$phone){
        $message_body = 'Dear '.$username.', Welcome to VUJADETEC. Your registration has been completed.';
        //$message_body .='Please pay by clicking the link https://vujadetec to buy & get services.';
        $message_body .='Please visit www.vujadetec.com to get more information about our product & services.';
        $response = SMS::sendSingleSms($phone,$message_body);
        return $response;
    }

    public static function send7dayWarningSms($phone,$message_body){
        $response = SMS::sendSingleSms($phone,$message_body);
        return $response;
    }

    public static function sendPastDayWarningSms($phone,$message_body){
        $response = SMS::sendSingleSms($phone,$message_body);
        return $response;
    }

    /*
     * Store sms sending record
     * */
    public static function storeSmsRecord($user_id, $content){
        try{
            $sms = NEW UserSms();
            $sms->user_id = $user_id;
            $sms->content = $content;
            $sms->save();

            return 'ok';
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /*
     * Saving error log
     * */
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

    public static function getUnreadMessageCount($user_id=''){
        $messages = MessageDetails::select('message_details.*','user.username as user_name','user.photo as user_photo','admin.username as admin_name','admin.photo as admin_photo');
        $messages = $messages->join('messages','messages.id','=','message_details.message_id');
        $messages = $messages->join('users as user','user.id','=','messages.user_id');
        $messages = $messages->join('users as admin','admin.id','=','messages.admin_id');
        if($user_id ==''){ // Message for admin
            $messages = $messages->where('type','sent');
        }
        else{// Message for user
            $messages = $messages->where('messages.user_id',$user_id);
            $messages = $messages->where('type','received');
        }
        $messages = $messages->where('is_read',0);
        $messages = $messages->count();
        return $messages;
    }

    public static function formatPhoneNumber($phone){
        $phone = str_replace(" ","",$phone);
        $phone = str_replace("-","",$phone);
        $phone = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $phone);
        return $phone;
    }

}//End
