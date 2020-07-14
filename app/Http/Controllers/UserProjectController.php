<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\TaskTitle;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Project;
use App\Models\Task;
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
    public function selectShipment(Request $request){
        try{
            if (Auth::check()) {
                $offer = Offer::first();
                $user = User::where('users.id', $request->id)->first();
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
        try{
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

            return ['status'=>200, 'reason'=>'Shipment date successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'storeShipment', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
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
                if ($request->u_id == '') {
                    $user_id = Session::get('user_id');
                } else {
                    $user_id = $request->u_id;
                }

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
                    ->where('users.status','active')
                    ->orderBy('parent_id','ASC')
                    ->get();
                $projects = UserProject::with('running_task','last_task')
                    ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id', 'user_projects.has_special_date','user_projects.special_date','user_projects.user_id')
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
                $u_project->save();

                $project_tasks = UserProjectTask::where('user_project_id',$u_project->id)
                    ->select('user_project_tasks.*','tasks.days_to_add')
                    ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                    ->get();

                /*
                 * Add user project tasks due date
                 * */
                foreach($project_tasks as $key=>$p_task){
                    $p_task->due_date = date('Y-m-d', strtotime($request->special_date. ' + '.$p_task->days_to_add.' days'));
                    $p_task->original_delivery_date = date('Y-m-d', strtotime($request->special_date. ' + '.$p_task->days_to_add.' days'));
                    $p_task->save();
                }
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

    public function myProjectTask(Request $request){
        try{
            if (Auth::check()) {
                $user_project_id = $request->id;
                $tasks = UserProjectTask::select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule')
                    ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                    ->join('task_title', 'task_title.id', '=', 'tasks.title_id')
                    ->where('user_project_id', $user_project_id)
                    ->where('tasks.status', 'active')
                    ->get();

                $task_titles = TaskTitle::where('status','!=','deleted')
                    ->get();

                if (!empty($tasks)) {
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
                    $returnHTML = View::make('user.project.my_project_task',
                        compact('user_project_id','project', 'tasks','shipment','task_titles'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.my_project_task', compact('user_project_id','project', 'tasks', 'shipment','task_titles'));
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
        //try{
            $date_updated = 0;
            $date_increased = 0;
            $daysAdded = 0;
            $task = UserProjectTask::where('user_project_tasks.id',$request->project_task_id)
                ->select('user_project_tasks.*','tasks.has_freeze_rule')
                ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                ->first();

            /*
             * Check if original delivery date updated and then update next tasks original delivery date
             * */
            if($request->original_delivery_date !='' && ($request->original_delivery_date != $request->old_delivery_date)){
                $date_updated = 1;
                $delivery_date_update_count  = $task->delivery_date_update_count+1;

                $daysAdded = Common::getDateDiffDays($request->original_delivery_date,$request->old_delivery_date);
                if($daysAdded>0) { // If date increased
                    $date_increased = 1;
                }
            }
            else{
                $delivery_date_update_count  = $task->delivery_date_update_count;
            }

            /*
             * Check if task made done by checking done tag
             * */
            if($date_updated==1){
                $task->delivery_date_update_count = $delivery_date_update_count;
            }
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
                $this->makeImmediateNextTaskProcessing($request->project_task_id,$task->user_project_id);
            }

            /*
             * Update next task original due date if date updated by user
             * */
            if($date_updated==1){
                $this->updateNextTaskOriginalDeliveryDate($request->project_task_id,$task->user_project_id,$date_increased,$daysAdded);
                if($task->has_freeze_rule==1){
                    $this->disableNextTaskOriginalDeliveryDateEdit($request->project_task_id,$task->user_project_id);
                }
            }


            return ['status'=>200, 'reason'=>'Successfully updated'];
        /*}
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    private function makePreviousTaskNotEditable($project_task_id,$user_project_id){
        $next_task = UserProjectTask::where('user_project_tasks.id','<',$project_task_id)
            ->select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('delivery_date_update_count','<',2)
            ->orderBy('user_project_tasks.id','ASC')
            ->first();
        if(!empty($next_task)){
            $next_task->delivery_date_update_count = 2;
            $next_task->save();
        }
    }

    private function makeImmediateNextTaskProcessing($project_task_id,$user_project_id){
        $next_task = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('user_project_tasks.freeze_forever',0)
            ->orderBy('user_project_tasks.id','ASC')
            ->first();
        if(!empty($next_task)){
            $next_task->status = 'processing';
            $next_task->save();
        }
    }

    private function updateNextTaskOriginalDeliveryDate($project_task_id,$user_project_id,$date_increased,$daysAdded){
        /*
         * Get all next task of this user project
         * */
        $project_tasks = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->whereIn('user_project_tasks.status',['not initiate','processing'])
            ->where('tasks.update_date_with','self_task')
            ->get();


        foreach($project_tasks as $key=>$p_task){
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
}
