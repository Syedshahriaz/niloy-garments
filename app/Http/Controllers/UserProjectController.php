<?php

namespace App\Http\Controllers;

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
                $user = User::where('users.id', $request->id)->first();
                $shipment = UserShipment::where('user_id', $user->id)->first();
                if (!empty($shipment)) {
                    return redirect('all_project');
                }
                if ($request->ajax()) {
                    $returnHTML = View::make('user.project.select_shipment', compact('user'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.select_shipment', compact('user'));
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
            $user = User::where('users.id',$request->user_id)
                ->select('users.*','user_payments.created_at as purchase_date')
                ->join('user_payments','user_payments.user_id','=','users.id')
                ->first();
            $user->gender = $request->gender;
            $user->save();

            $purchase_date = $user->purchase_date;
            $offer = $request->offer;
            $gender = $request->gender;

            /*
             * Save shipment date
             * */
            $shipment = NEW UserShipment();
            $shipment->user_id = $request->user_id;
            $shipment->shipment_date = date('Y-m-d',strtotime($request->shipment_date));
            if($request->offer == 1){
                $shipment->has_ofer_1 = 1;
                $shipment->has_ofer_2 = 0;
            }
            else{
                $shipment->has_ofer_1 = 0;
                $shipment->has_ofer_2 = 1;
            }
            if($request->gender == 'Female'){
                $shipment->has_ofer_3 = 1;
            }

            $shipment->save();

            //@todo Add project based on selected offer

            /*
             * Add user project
             * */
            $projects = Project::select('projects.*','tasks.title','tasks.days_to_add','user_projects.id as user_project_id');
            $projects = $projects->leftJoin('tasks','tasks.project_id','=','projects.id');
            $projects = $projects->leftJoin('user_projects','user_projects.project_id','=','projects.id');
            $projects = $projects->where('projects.status','active');
            $projects = $projects->where(function ($query) use ($offer,$gender) {
                if($offer==1){
                    $query->orWhere('has_offer_1', 1);
                }
                else{
                    $query->orWhere('has_offer_2', 1);
                }
                
                if($gender == 'Female'){
                    $query->orWhere('has_offer_3', 1);
                }
            });
            $projects = $projects->groupBy('projects.id');
            $projects = $projects->get();

            foreach($projects as $key=>$project){
                $userProject = NEW UserProject();
                $userProject->user_id = $user->id;
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

                $tasks = Task::where('project_id',$project->id)
                    //->where('status','active')
                    ->get();

                /*
                 * Saving user project tasks
                 * */
                foreach($tasks as $key=>$task){
                    $projectTask = NEW UserProjectTask();
                    $projectTask->user_project_id = $userProject->id;
                    $projectTask->task_id = $task->id;
                    if($task->status =='active'){
                        if($project->day_add_with=='shipment_date') {
                            $projectTask->due_date = date('Y-m-d',
                                strtotime($shipment->shipment_date . ' + ' . $task->days_to_add . ' days'));
                            $projectTask->original_delivery_date = date('Y-m-d',
                                strtotime($shipment->shipment_date . ' + ' . $task->days_to_add . ' days'));
                        }
                        else if($project->day_add_with=='purchase_date'){
                            $projectTask->due_date = date('Y-m-d',
                                strtotime($purchase_date . ' + ' . $task->days_to_add . ' days'));
                            $projectTask->original_delivery_date = date('Y-m-d',
                                strtotime($purchase_date . ' + ' . $task->days_to_add . ' days'));
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
                    $projectTask->save();
                }
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Shipment date successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'storeShipment', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
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

                $child_users = User::where('users.email', Session::get('user_email'))
                    ->select('users.*', 'user_shipments.shipment_date')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->orderBy('parent_id','ASC')
                    ->get();
                $projects = UserProject::with('running_task','last_task')
                    ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id', 'user_projects.has_special_date','user_projects.special_date')
                    ->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id')
                    ->leftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
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
            /*SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'allProject', $e->getLine(),
                $e->getFile(), '', '', '', '');*/
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectSpecialDate(Request $request){
        try{
            DB::beginTransaction();

            $user_id = Session::get('user_id');

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
                $tasks = UserProjectTask::select('user_project_tasks.*', 'tasks.title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id')
                    ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                    ->where('user_project_id', $user_project_id)
                    ->get();

                if (!empty($tasks)) {
                    $project = Project::select('projects.*')
                        ->where('id', $tasks[0]->project_id)
                        ->first();
                } else {
                    $project = array();
                }


                //echo "<pre>"; print_r($tasks); echo "</pre>"; exit();

                if ($request->ajax()) {
                    $returnHTML = View::make('user.project.my_project_task',
                        compact('user_project_id','project', 'tasks'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.my_project_task', compact('user_project_id','project', 'tasks'));
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
            $task = UserProjectTask::where('id',$request->project_task_id)->first();

            /*
             * Check if original delivery date updated and then update next tasks original delivery date
             * */
            if($request->original_delivery_date !='' && ($request->original_delivery_date != $request->old_delivery_date)){
                $date_updated = 1;
                $delivery_date_update_count  = $task->delivery_date_update_count+1;

                $timeDiff = strtotime($request->original_delivery_date) - strtotime($request->old_delivery_date);
                $daysAdded = $timeDiff/86400;  // 86400 seconds in one day
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
}
