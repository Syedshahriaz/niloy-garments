<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Payments;
use App\Models\TaskTitle;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Project;
use App\Models\Task;
use App\Models\Payment;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\User;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use View;

class UserProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function selectShipment(Request $request){
        try{
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                $offer = Offer::first();
                $user = User::where('users.id', $request->id)->first();

                /*
                 * Check if payment done for this user
                 * */
                $payment = Payment::where('user_id', $user->id)->first();
                if (empty($payment)) {
                    return redirect('promotion/'.$user->id);
                }
                if ($payment->payment_status != 'Completed') {
                    return redirect('promotion/'.$user->id);
                }

                /*
                 * Check if shipment date selected already
                 * */
                $shipment = UserShipment::where('user_id', $user->id)->first();

                if (!empty($shipment) && $shipment->shipment_date != '') {
                    return redirect('all_project');
                }
                if ($request->ajax()) {
                    $returnHTML = View::make('user.project.select_shipment', compact('user','offer'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.select_shipment', compact('user','offer'));
            }
            else{
                return redirect('login');
            }
        }
         catch (\Exception $e) {
             SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'selectShipment', $e->getLine(),
                 $e->getFile(), '', '', '', '');
             // message, view file, controller, method name, Line number, file,  object, type, argument, email.
             return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
         }
    }

    public function storeShipment(Request $request){
        //try{
            DB::beginTransaction();

            /*
             * Update user
             * */
            $user = User::where('users.id',$request->user_id)
                ->select('users.*','user_payments.created_at as purchase_date')
                ->join('user_payments','user_payments.user_id','=','users.id')
                ->first();
            $user->gender = $request->gender;
            $user->save();

            $user_id = $user->id;
            $purchase_date = $user->purchase_date;
            $gender = $request->gender;
            $shipment_date = $request->shipment_date;

            /*
             * Save shipment date
             * */
            $shipment = $this->saveShipmentDetails($user_id,$gender,$shipment_date);

            $has_offer_1 = $shipment->has_ofer_1;
            $has_offer_2 = $shipment->has_ofer_2;

            /*
             * Get user project based on selected offer
             * */
            $projects = Common::getOfferedProject($gender,$has_offer_1,$has_offer_2);

            /*
             * Save user project
             * */
            $result = Common::saveUserProject($projects,$user_id,$shipment,$purchase_date);

            DB::commit();

            /*
             * check and prepare for task editable
             * */
            $result = Common::checkAndPrepareForTaskProcessing($user_id,$shipment_date);

            Session::put('selected_user',$user_id);

            /*
             * Check and send task warning email and sms
             * */
            $result = Common::sendTaskWarningEmail($user_id);

            return ['status'=>200, 'reason'=>'Shipment date successfully saved'];
        /*}
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'storeShipment', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    private function saveShipmentDetails($user_id,$gender,$shipment_date){
        $shipment = UserShipment::where('user_id',$user_id)->first();
        $shipment->shipment_date = date('Y-m-d',strtotime($shipment_date));
        if($gender == 'Female'){
            $shipment->has_ofer_3 = 1;
        }
        $shipment->save();

        return $shipment;
    }

    public function allProject(Request $request){
        try{
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                if ($request->u_id == '') {
                    if(Session::get('selected_user') != ''){
                        $user_id = Session::get('selected_user');
                    }
                    else{
                        $user_id = Session::get('user_id');
                    }
                } else {
                    $user_id = $request->u_id;
                }

                Session::put('selected_user',$user_id);

                $user = User::where('users.id', $user_id)->first();
                $setting = Setting::select('message_to_user')->first();

                $shipment = UserShipment::where('user_id', $user_id)->first();
                if (empty($shipment)) {
                    return redirect('select_shipment/'.$user_id);
                }
                if ($shipment->shipment_date == '') {
                    return redirect('select_shipment/'.$user_id);
                }

                $child_users = User::where('users.email', Session::get('user_email'))
                    ->select('users.*', 'user_shipments.shipment_date')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->whereIn('users.status',['active','pending'])
                    //->orderBy('parent_id','ASC')
                    ->get();
                $projects = UserProject::with('running_task','last_task','completed_tasks')
                    ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id', 'user_projects.has_special_date','user_projects.special_date','user_projects.special_date_update_count','user_projects.user_id')
                    ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                    ->join('tasks', 'tasks.project_id', '=', 'projects.id')
                    ->where('user_projects.user_id', $user_id)
                    ->where('projects.status', 'active')
                    ->groupBy('projects.id')
                    ->get();

                //return $user_id;
                if ($request->ajax()) {
                    $returnHTML = View::make('user.project.all_project',
                        compact('user_id','setting', 'child_users', 'shipment', 'projects'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.all_project',
                    compact('user_id','setting', 'child_users', 'shipment', 'projects'));
            }
            else{
                return redirect('login');
            }
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'allProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectSpecialDate(Request $request){
        try{
            DB::beginTransaction();

            $user_id = $request->user_id;

            $user_projects = UserProject::where('user_id',$user_id)
                    ->where('has_special_date',1)
                    ->get();

            foreach($user_projects as $key=>$u_project){
                $u_project->special_date = date('Y-m-d', strtotime($request->special_date));
                $u_project->special_date_update_count = $u_project->special_date_update_count+1;
                $u_project->save();

                $project_tasks = UserProjectTask::where('user_project_id',$u_project->id)
                    ->select('user_project_tasks.*','tasks.days_to_add')
                    ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                    ->get();

                /*
                 * Add user project tasks due date
                 * */
                $result = $this->addSpecialDateToProjectTask($project_tasks,$request->special_date);
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'updateProjectSpecialDate', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function addSpecialDateToProjectTask($project_tasks,$special_date){
        foreach($project_tasks as $key=>$p_task){
            $p_task->due_date = date('Y-m-d', strtotime($special_date. ' + '.$p_task->days_to_add.' days'));
            $p_task->original_delivery_date = date('Y-m-d', strtotime($special_date. ' + '.$p_task->days_to_add.' days'));
            $p_task->save();
        }
    }

    public function myProjectTask(Request $request){
        try{
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                $user_project_id = $request->id;
                $user = UserProject::select('users.id','users.username', 'users.email','has_special_date','special_date')
                    ->join('users','users.id','=','user_projects.user_id')
                    ->where('user_projects.id',$user_project_id)
                    ->first();

                $tasks = UserProjectTask::select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule','projects.has_offer_1')
                    ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                    ->join('projects', 'projects.id', '=', 'tasks.project_id')
                    ->join('task_title', 'task_title.id', '=', 'tasks.title_id')
                    ->where('user_project_id', $user_project_id)
                    ->where('tasks.status', 'active')
                    ->get();

                $task_titles = TaskTitle::where('status','!=','deleted')
                    ->get();

                if (count($tasks) != 0) {
                    $project = Project::select('projects.*')
                        ->where('id', $tasks[0]->project_id)
                        ->first();
                } else {
                    $project = array();
                }

                $shipment = UserProject::select('user_shipments.*')
                    ->join('user_shipments','user_shipments.user_id','user_projects.user_id')
                    ->where('user_projects.id',$user_project_id)
                    ->first();
                //echo "<pre>"; print_r($tasks); echo "</pre>"; exit();

                if ($request->ajax()) {
                    if(empty($user)){
                        return [ 'status' => 401, 'reason' => 'This project have been removed.'];
                    }

                    $returnHTML = View::make('user.project.my_project_task',
                        compact('user_project_id','user','project', 'tasks','shipment','task_titles'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }

                if(empty($user)){ // User task not generated yet
                    return redirect('error_404');
                }
                if($user->email != Session::get('user_email')){ // Logged in user allowed only
                    return redirect('error_404');
                }
                if($user->has_special_date==1 && $user->special_date == ''){ // Need to select special date
                    return redirect('all_project?u_id='.$user->id);
                }

                return view('user.project.my_project_task', compact('user_project_id','user','project', 'tasks', 'shipment','task_titles'));
            }
            else{
                return redirect('login');
            }
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectTaskDeliveryStatus(Request $request){
        try{
            $date_updated = 0;
            $date_increased = 0;
            $daysAdded = 0;
            $task = UserProjectTask::where('user_project_tasks.id',$request->project_task_id)
                ->select('user_project_tasks.*','tasks.has_freeze_rule','user_projects.user_id')
                ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                ->join('user_projects','user_projects.id','=','user_project_tasks.user_project_id')
                ->first();

            if($task->delivery_date_update_count>1){
                return ['status'=>200, 'reason'=>'Task already completed and locked.'];
            }

            $shipment = UserShipment::where('user_id', $task->user_id)->first();

            /*
             * Check if original delivery date updated and then update next tasks original delivery date
             * */
            if($request->original_delivery_date !='' && ($request->original_delivery_date != $request->old_delivery_date)){
                $date_updated = 1;
                //$delivery_date_update_count  = $task->delivery_date_update_count+1;

                $daysAdded = Common::getDateDiffDays($request->original_delivery_date,$request->old_delivery_date);
                if($daysAdded>0) { // If date increased
                    $date_increased = 1;
                }
            }
            else{
                //$delivery_date_update_count  = $task->delivery_date_update_count;
            }

            /*
             * Check if task made done by checking done tag
             * */
            //if($date_updated==1){
                $delivery_date_update_count  = $task->delivery_date_update_count+1;
                $task->delivery_date_update_count = $task->delivery_date_update_count+1;
            //}
            if($request->original_delivery_date !=''){
                $task->status = 'completed';
                $task->original_delivery_date = date('Y-m-d', strtotime($request->original_delivery_date));

                $this->makePreviousTaskNotEditable($request->project_task_id,$task->user_project_id);

            }
            $task->save();

            /*
             * Make immediate next task to processing
             * */
            if($delivery_date_update_count < 2 ){
                $next_task = $this->makeImmediateNextTaskProcessing($request->project_task_id,$task->user_project_id,$shipment->shipment_date);
                if(!empty($next_task)){
                    $result = $this->makePreviousNotInitiateTaskForeverFreeze($task->user_project_id);
                }
            }

            /*
             * Update next task original due date if date updated by user
             * */
            if($date_updated==1){
                $result = $this->updateNextTaskOriginalDeliveryDate($request->project_task_id,$task->user_project_id,$date_increased,$daysAdded);
                if($task->has_freeze_rule==1){
                    //$this->disableNextTaskOriginalDeliveryDateEdit($request->project_task_id,$task->user_project_id);
                }
            }


            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function makePreviousTaskNotEditable($project_task_id,$user_project_id){
        $prev_tasks = UserProjectTask::select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_tasks.id','<',$project_task_id)
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('delivery_date_update_count','<',2)
            ->orderBy('user_project_tasks.id','ASC')
            ->get();
        foreach($prev_tasks as $task){
            $taskData = UserProjectTask::where('id',$task->id)->first();
            $taskData->delivery_date_update_count = 2;
            $taskData->status = 'completed';
            $taskData->save();
        }
    }

    private function makeImmediateNextTaskProcessing($project_task_id,$user_project_id,$shipment_date){
        $next_task = $this->getNextTask($project_task_id,$user_project_id);
        if(!empty($next_task)){
            $task_in_date_range = Common::task_in_date_range($shipment_date,$next_task->days_range_start,$next_task->days_range_end);
            if($task_in_date_range==0){
                /*$next_task->freeze_forever = 1;
                $next_task->save();*/

                $result = $this->makeImmediateNextTaskProcessing($next_task->id,$user_project_id,$shipment_date);
            }
            else{
                $next_task->status = 'processing';
                $next_task->save();

                $today = date('Y-m-d');
                $next_day = date('Y-m-d', strtotime('+1 days'));
                $allow_date = date('Y-m-d', strtotime('+7 days'));
                $email = [$next_task->email];
                if($next_task->original_delivery_date<$today){ // Due date have been past
                    /*
                     * Send past warning sms
                     * */
                    $message_body ='Dear '.$next_task->username.', Your Project '.$next_task->project_name.' '.$next_task->task_name.' due date is on '.date('d F, Y',strtotime($next_task->original_delivery_date)).'. Please visit www.vujadetec.com to get more information about our product & services';
                    $email_body ='Dear '.$next_task->username.', <br>Your Project '.$next_task->project_name.' '.$next_task->task_name.' due date is on '.date('d F, Y',strtotime($next_task->original_delivery_date)).'. <br>Please visit <a href="www.vujadetec.com">www.vujadetec.com</a> to get more information about our product & services';
                    $sms_response = Common::sendPastDayWarningSms($next_task->phone,$message_body);
                    $email_response = Common::sendPastDayWarningEmail($email,$email_body);

                }
                else if($next_task->original_delivery_date>=$next_day && $next_task->original_delivery_date<=$allow_date){
                    $message_body ='Dear '.$next_task->username.', Your Project '.$next_task->project_name.' '.$next_task->task_name.' due date is on '.date('d F, Y',strtotime($next_task->original_delivery_date)).'. Please visit www.vujadetec.com to get more information about our product & services';
                    $email_body ='Dear '.$next_task->username.', <br>Your Project '.$next_task->project_name.' '.$next_task->task_name.' due date is on '.date('d F, Y',strtotime($next_task->original_delivery_date)).'. <br>Please visit <a href="www.vujadetec.com">www.vujadetec.com</a> to get more information about our product & services';
                    $sms_response = Common::send7dayWarningSms($next_task->phone,$message_body);
                    $email_response = Common::send7dayWarningEmail($email,$email_body);
                }

                return 1;
            }
        }
        return 1;
    }

    private function getNextTask($project_task_id,$user_project_id){
        $next_task = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*','projects.name as project_name','task_title.name as task_name', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule','users.username','users.email','users.phone')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->join('task_title', 'task_title.id', '=', 'tasks.title_id')
            ->join('user_projects','user_projects.id','=','user_project_tasks.user_project_id')
            ->join('projects','projects.id','=','user_projects.project_id')
            ->join('users','users.id','=','user_projects.user_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('user_project_tasks.freeze_forever',0)
            ->orderBy('user_project_tasks.id','ASC')
            ->first();
        return $next_task;
    }

    private function updateNextTaskOriginalDeliveryDate($project_task_id,$user_project_id,$date_increased,$daysAdded){
        /*
         * Get all next task of this user project
         * */

        $previous_task = UserProjectTask::where('user_project_tasks.id',$project_task_id)
            ->first();

        $project_tasks = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*','tasks.date_update_dependent_with')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->whereIn('user_project_tasks.status',['not initiate','processing'])
            ->where('tasks.update_date_with','self_task')
            ->get();


        foreach($project_tasks as $key=>$p_task){
            if($p_task->date_update_dependent_with==''){
                $taskData = UserProjectTask::where('id',$p_task->id)->first();
                if($date_increased==1){ // If date increased
                    $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' + '.abs($daysAdded).' days'));
                    $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' + '.abs($daysAdded).' days'));
                }
                else{
                    $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' - '.abs($daysAdded).' days'));
                    $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' - '.abs($daysAdded).' days'));
                }
                $taskData->save();
            }
            else{
                if($p_task->date_update_dependent_with==$previous_task->task_id){
                    $taskData = UserProjectTask::where('id',$p_task->id)->first();
                    if($date_increased==1){ // If date increased
                        $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' + '.abs($daysAdded).' days'));
                        $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' + '.abs($daysAdded).' days'));
                    }
                    else{
                        $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' - '.abs($daysAdded).' days'));
                        $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' - '.abs($daysAdded).' days'));
                    }
                    $taskData->save();
                }
            }
        }
    }

    private function disableNextTaskOriginalDeliveryDateEdit($project_task_id,$user_project_id){
        /*
         * Get all next task of this user project
         * */
        $project_tasks = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('user_project_tasks.freeze_forever',2)
            ->get();

        foreach($project_tasks as $key=>$p_task){
            $taskData = UserProjectTask::where('id',$p_task->id)->first();
            $taskData->freeze_forever = 1;
            $taskData->save();
        }
    }

    private function makePreviousNotInitiateTaskForeverFreeze($user_project_id){
        /*
         * Get all previous not initiate task of this user project
         * */
        $processing_task = UserProjectTask::select('user_project_tasks.*')
            ->where('user_project_id',$user_project_id)
            ->where('user_project_tasks.status','processing')
            ->first();

        if(!empty($processing_task)){
            $project_tasks = UserProjectTask::where('user_project_tasks.id','<',$processing_task->id)
                ->select('user_project_tasks.*')
                ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                ->where('user_project_id',$user_project_id)
                ->where('tasks.status','active')
                ->where('user_project_tasks.status','not initiate')
                ->get();

            foreach($project_tasks as $key=>$p_task){
                $taskData = UserProjectTask::where('id',$p_task->id)->first();
                $taskData->freeze_forever = 1;
                $taskData->save();
            }
        }
    }
}
