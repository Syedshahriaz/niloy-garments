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
    public function allProject(Request $request){
        //try{
            $user = User::where('users.id',Session::get('user_id'))->first();
            $shipment = UserShipment::where('user_id',$user->id)->first();
            if(empty($shipment)){
                return redirect('select_shipment');
            }
            $projects = Project::select('projects.*','tasks.title','tasks.days_to_add','user_projects.id as user_project_id')
                ->leftJoin('tasks','tasks.project_id','=','projects.id')
                ->leftJoin('user_projects','user_projects.project_id','=','projects.id')
                ->where('projects.status','active')
                ->groupBy('projects.id')
                ->get();
            
            $my_projects = Project::select('user_projects.project_id')
            ->where('status','active')
            ->join('user_projects','user_projects.project_id','=','projects.id')
            ->where('user_projects.user_id',Session::get('user_id'))
            ->pluck('user_projects.project_id')
            ->toArray();
            if($request->ajax()) {
                $returnHTML = View::make('user.project.all_project',compact('shipment','projects','my_projects'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.project.all_project',compact('shipment','projects','my_projects'));
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'allProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function selectShipment(Request $request){
        //try{
            $user = User::where('users.id',Session::get('user_id'))->first();
            $shipment = UserShipment::where('user_id',$user->id)->first();
            if(!empty($shipment)){
                return redirect('all_project');
            }
            if($request->ajax()) {
                $returnHTML = View::make('user.project.select_shipment', compact('user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.project.select_shipment', compact('user'));
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

            return ['status'=>200, 'reason'=>'Shipment date successfully saved'];
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'storeShipment', $e->getLine(),
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
            $project = Project::select('projects.*')
                ->where('id',$request->project_id)
                ->first();

            $tasks = UserProjectTask::select('user_project_tasks.*')
                ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                ->where('user_project_id',$request->id)
                ->get();

            if($request->ajax()) {
                $returnHTML = View::make('user.project.my_project_task',compact('project','tasks'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.project.my_project_task',compact('project','tasks'));
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function updateProjectTaskStatus(Request $request){
        //try{
            $date_updated = 0;
            $date_increased = 0;
            $task = UserProjectTask::where('id',$request->project_task_id)->first();

            /*
             * Check if original delivery date updated and then update next tasks original delivery date
             * */
            if($request->original_delivery_date != $request->old_delivery_date){
                $date_updated = 1;
                $delivery_date_update_count  = $task->delivery_date_update_count+1;

                if($request->old_delivery_date > $request->original_delivery_date){
                    $date_increased = 1;
                    $timeDiff = abs(strtotime($request->old_delivery_date) - strtotime($request->original_delivery_date));
                    $daysAdded = $timeDiff/86400;  // 86400 seconds in one day
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
            $task->save();

            /*
             * Update next task original due date if date updated by user
             * */
            if($date_updated==1){
                /*
                 * Get all next task of this user project
                 * */
                $tasks = UserProjectTask::where('id','>',$request->project_task_id)
                    ->where('user_project_id',$request->user_project_id)
                    ->get();

                foreach($tasks as $task){
                    $taskData = UserProjectTask::where('id',$task->id)->first();
                    $taskData->original_delivery_date = date('Y-m-d', strtotime($task->original_delivery_date. ' + '.$daysAdded.' days'));
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
