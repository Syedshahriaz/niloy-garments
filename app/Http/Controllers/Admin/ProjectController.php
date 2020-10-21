<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserProject;
use App\Models\UserShipment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskTitle;
use App\Models\UserProjectTask;
use App\Models\Notification;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request){
        try{
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }

            if(!Common::can_access('project_setting')){
                return redirect('error_404');
            }

            $projects = Project::with('tasks')
                ->where('status','!=','deleted')
                ->get();
            $task_titles = TaskTitle::where('status','!=','deleted')
                ->get();
            if($request->ajax()) {
                $returnHTML = View::make('admin.project.all_project',compact('projects','task_titles'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.project',compact('projects','task_titles'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'index', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function create(Request $request){
        try{
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            if($request->ajax()) {
                $returnHTML = View::make('admin.project.create_project')->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.project.create_project');
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'index', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function store(Request $request){
        try{
            $user = Auth::user();
            $project = NEW Project();
            $project->name = $request->name;
            $project->fabrication = $request->fabrication;
            $project->color = $request->color;
            $project->quantity = $request->quantity;
            $project->size_range = $request->size_range;
            $project->created_by = $user->id;
            $project->save();
            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'store', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getProjectAjax(Request $request){
        try{
            $project = Project::where('id',$request->project_id)->first();
            return ['status'=>200, 'reason'=>'', 'project'=>$project];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'getProjectAjax', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProject(Request $request){
        try{
            //echo "<pre>"; print_r($request->all()); echo "</pre>"; exit();
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->name = $request->name;
            $project->sub_title = $request->sub_title;
            $project->description = $request->description;
            $project->type = $request->project_type;
            $project->updated_by = $user->id;
            $project->updated_at = date('Y-m-d');
            $project->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectStatus(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->status = $request->status;
            $project->updated_at = date('Y-m-d');
            return ['status'=>200, 'reason'=>'Project made '.$request->status.' successfully'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateStatus', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateTaskTitle(Request $request){
        try{
            $task = TaskTitle::where('id',$request->title_id)->first();
            $task->name = $request->title_name;
            $task->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateTaskTitle', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateTaskRule(Request $request){
        try{
            $user = Auth::user();
            $task = Task::where('id',$request->task_id)->first();
            $task->rule = $request->rule_name;
            $task->updated_at = date('Y-m-d');
            $task->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateTaskRule', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateTaskStatus(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->status = $request->status;
            return ['status'=>200, 'reason'=>'Project made '.$request->status.' successfully'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateTaskStatus', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function unlockProjectTask(Request $request){
        try{
            $project_task = UserProjectTask::where('id',$request->project_task_id)->first();
            if($project_task->delivery_date_update_count != 0){
                $project_task->delivery_date_update_count = 1;
            }
            $project_task->save();

            $user_project = UserProject::select('user_projects.user_id','projects.name','users.parent_id','users.unique_id')
                ->join('projects','projects.id','=','user_projects.project_id')
                ->join('users','users.id','=','user_projects.user_id')
                ->where('user_projects.id',$project_task->user_project_id)
                ->first();

            $project_task_details = UserProjectTask::select('user_project_tasks.id','task_title.name as task_name','tasks.rule')
                ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                ->join('task_title','task_title.id','=','tasks.title_id')
                ->where('user_project_tasks.id',$request->project_task_id)
                ->first();

            $message = "Member ".$user_project->unique_id.": Task ".$project_task_details->task_name." of project ".$user_project->name." have been unlocked";

            /*
             * Save notification
             * */
            $result = Common::saveNotification($user_project,$message);

            return ['status'=>200, 'reason'=>'Project task unlocked successfully'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'unlockProjectTask', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function unlockShippingDate(Request $request){
        try{
            $shipment = UserShipment::where('user_id', $request->user_id)->first();
            if($shipment->shipment_date_update_count != 0){
                $shipment->shipment_date_update_count = 0;
            }
            $shipment->save();

            $user = User::select('users.*','users.id as user_id')->where('id',$request->user_id)->first();
            $message = "Member ".$user->unique_id.": Birth date have been unlocked";

            /*
             * Save notification
             * */
            $result = Common::saveNotification($user,$message);

            return ['status'=>200, 'reason'=>'Shipment date unlocked successfully'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'unlockShippingDate', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
