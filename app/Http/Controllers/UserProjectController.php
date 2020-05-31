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
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class UserProjectController extends Controller
{
    public function selectShipment(Request $request){
        //try{
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
        /* }
         catch (\Exception $e) {
             SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'selectShipment', $e->getLine(),
                 $e->getFile(), '', '', '', '');
             // message, view file, controller, method name, Line number, file,  object, type, argument, email.
             return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
         }*/
    }

    public function storeShipment(Request $request){
        //try{
            $user = User::where('users.id',$request->user_id)->first();
            $user->gender = $request->gender;
            $user->save();

            /*
             * Save shipment date
             * */
            $shipment = NEW UserShipment();
            $shipment->user_id = $request->user_id;
            $shipment->shipment_date = date('Y-m-d',strtotime($request->shipment_date));
            $shipment->save();

            /*
             * Add user project
             * */
            $projects = Project::select('projects.*','tasks.title','tasks.days_to_add','user_projects.id as user_project_id')
                ->leftJoin('tasks','tasks.project_id','=','projects.id')
                ->leftJoin('user_projects','user_projects.project_id','=','projects.id')
                ->where('projects.status','active')
                ->groupBy('projects.id')
                ->get();

            foreach($projects as $key=>$project){
                $userProject = NEW UserProject();
                $userProject->user_id = $user->id;
                $userProject->project_id = $project->id;
                $userProject->start_date = date('Y-m-d', strtotime($shipment->shipment_date. ' + '.$project->days_to_add.' days'));
                $userProject->save();

                $tasks = Task::where('project_id',$project->id)->get();

                /*
                 * Saving user project tasks
                 * */
                foreach($tasks as $key=>$task){
                    $projectTask = NEW UserProjectTask();
                    $projectTask->user_project_id = $userProject->id;
                    $projectTask->task_id = $task->id;
                    $projectTask->due_date = date('Y-m-d', strtotime($shipment->shipment_date. ' + '.$task->days_to_add.' days'));
                    $projectTask->original_delivery_date = date('Y-m-d', strtotime($shipment->shipment_date. ' + '.$task->days_to_add.' days'));
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
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'storeShipment', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function allProject(Request $request){
        //try{
        if (Auth::check()) {
            if ($request->u_id == '') {
                $user_id = Session::get('user_id');
            } else {
                $user_id = $request->u_id;
            }

            $user = User::where('users.id', $user_id)->first();
            $child_users = User::where('users.email', Session::get('user_email'))
                ->select('users.*', 'user_shipments.shipment_date')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->get();
            $shipment = UserShipment::where('user_id', $user_id)->first();
            if (empty($shipment)) {
                return redirect('select_shipment/'.$user_id);
            }
            $projects = UserProject::with('running_task','last_task')
                ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id')
                ->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id')
                ->leftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
                ->where('user_projects.user_id', $user_id)
                ->where('projects.status', 'active')
                ->groupBy('projects.id')
                ->get();

            $my_projects = Project::select('user_projects.project_id')
                ->where('status', 'active')
                ->join('user_projects', 'user_projects.project_id', '=', 'projects.id')
                ->where('user_projects.user_id', $user_id)
                ->pluck('user_projects.project_id')
                ->toArray();

            //return $user_id;
            if ($request->ajax()) {
                $returnHTML = View::make('user.project.all_project',
                    compact('user_id', 'child_users', 'shipment', 'projects',
                        'my_projects'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.project.all_project',
                compact('user_id', 'child_users', 'shipment', 'projects', 'my_projects'));
        }
        else{
            return redirect('login');
        }
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'allProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function addProject(Request $request){
        //try{
            DB::beginTransaction();

            $user = User::where('users.id',Session::get('user_id'))->first();
            $project_checks = $request->project_check;
            $projects = $request->project_id;
            $startDates = $request->start_dates;

            foreach($project_checks as $key=>$check){
                if($project_checks[$key]==1){
                    $userProject = NEW UserProject();
                    $userProject->user_id = $user->id;
                    $userProject->project_id = $projects[$key];
                    $userProject->start_date = $startDates[$key];
                    $userProject->save();

                    $tasks = Task::where('project_id',$projects[$key])->get();

                    /*
                     * Saving user project tasks
                     * */
                    foreach($tasks as $key=>$task){
                        $projectTask = NEW UserProjectTask();
                        $projectTask->user_project_id = $userProject->id;
                        $projectTask->task_id = $task->id;
                        $projectTask->due_date = date('Y-m-d', strtotime($startDates[$key]. ' + '.$task->days_to_add.' days'));
                        $projectTask->original_delivery_date = date('Y-m-d', strtotime($startDates[$key]. ' + '.$task->days_to_add.' days'));
                        if($key==0){
                            $projectTask->status = 'processing';
                        }
                        else{
                            $projectTask->status = 'not initiate';
                        }
                        $projectTask->save();
                    }
                }
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        /*}
        catch (\Exception $e) {
            DB::rollback();
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'addProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function myProject(Request $request){
        //try{
            $projects = Project::select('user_projects.*','projects.name','projects.fabrication','projects.color','projects.quantity','projects.size_range')
                ->where('status','active')
                ->join('user_projects','user_projects.project_id','=','projects.id')
                ->where('user_projects.user_id',Session::get('user_id'))
                ->get();
            if($request->ajax()) {
                $returnHTML = View::make('user.project.my_project',compact('projects'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.project.my_project',compact('projects'));
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function myProjectTask(Request $request){
        //try{
            if (Auth::check()) {
                $tasks = UserProjectTask::select('user_project_tasks.*', 'tasks.title', 'tasks.rule',
                    'tasks.project_id')
                    ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                    ->where('user_project_id', $request->id)
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
                        compact('project', 'tasks'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.my_project_task', compact('project', 'tasks'));
            }
            else{
                return redirect('login');
            }
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function updateProjectTaskDeliveryStatus(Request $request){
        //try{
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

                if($daysAdded>0){
                    $date_increased = 1;
                }
            }
            else{
                $delivery_date_update_count  = $task->delivery_date_update_count;
            }

            /*
             * Check if task made done by checking done tag
             * */
            if($request->is_done == 1){
                $task->status = 'completed';
            }
            if($date_updated==1){
                $task->delivery_date_update_count = $delivery_date_update_count;
            }
            if($request->original_delivery_date !=''){
                $task->original_delivery_date = date('Y-m-d', strtotime($request->original_delivery_date));
            }
            $task->save();

            /*
             * Start imediate next task to processing
             * */
            if($request->is_done == 1){
                $next_task = UserProjectTask::where('id','>',$request->project_task_id)
                    ->where('user_project_id',$task->user_project_id)
                    ->orderBy('id','ASC')
                    ->first();
                if(!empty($next_task)){
                    $next_task->status = 'processing';
                    $next_task->save();
                }
            }

            /*
             * Update next task original due date if date updated by user
             * */
            if($date_updated==1 && $date_increased==1){
                /*
                 * Get all next task of this user project
                 * */
                $tasks = UserProjectTask::where('id','>',$request->project_task_id)
                    ->where('user_project_id',$task->user_project_id)
                    ->get();

                foreach($tasks as $key=>$task){
                    $taskData = UserProjectTask::where('id',$task->id)->first();
                    $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' + '.$daysAdded.' days'));
                    $taskData->save();
                }
            }

            return ['status'=>200, 'reason'=>'Successfully updated'];
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }
}
